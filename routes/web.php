<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BloodBankController;
use NominatimLaravel\Content\Nominatim;
use App\Models\BloodBank;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\SiteController::class, 'getHome'])->name('getHome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/add/bloodinformation', [App\Http\Controllers\HomeController::class, 'postAddBlood'])->name('user.postAddBlood');
Route::get('/bloodrequest', [App\Http\Controllers\HomeController::class, 'getBloodRequest'])->name('user.getBloodRequest');
Route::post('/bloodrequest', [App\Http\Controllers\HomeController::class, 'postBloodRequest'])->name('user.postBloodRequest');
Route::get('/manage/requested/blood', [App\Http\Controllers\HomeController::class, 'getManageRequestBlood'])->name('user.getManageRequestBlood');
Route::get('/search/bloodgroup', [App\Http\Controllers\HomeController::class, 'getSearchBloodGroup'])->name('user.getSearchBloodGroup');
Route::get('/search/result', [App\Http\Controllers\HomeController::class, 'postSearchDonner'])->name('user.postSearchDonner');
Route::get('/blood/contribution', [App\Http\Controllers\HomeController::class, 'getContribution'])->name('user.getContribution');
Route::post('/blood/codinate', [App\Http\Controllers\HomeController::class, 'postStoreCoordinate'])->name('user.postStoreCoordinate');
Route::middleware('is_admin')->prefix('admin')->group(
    function () {
        Route::get('/home', [App\Http\Controllers\AdminController::class, 'adminHome'])->name('admin.home');
        Route::get('/donner/manage', [App\Http\Controllers\AdminController::class, 'getManageDonner'])->name('admin.getManageDonner');
        Route::post('/donner/add', [App\Http\Controllers\AdminController::class, 'postNewDonor'])->name('admin.postNewDonor');
        Route::get('/blood/request', [App\Http\Controllers\AdminController::class, 'getManageRequestBloodAdmin'])->name('admin.getManageRequestBlood');
        Route::get('/blood/requestdetail/{bloodrequest}', [App\Http\Controllers\AdminController::class, 'getRequestedBloodDetail'])->name('admin.getRequestedBloodDetail');

        Route::get('/blood/requestdetail/{bloodrequest}', [App\Http\Controllers\AdminController::class, 'getRequestedBloodDetail'])->name('admin.getRequestedBloodDetail');
        Route::post('/blood/requestdetail1/{bloodrequest}', [App\Http\Controllers\AdminController::class, 'postResponse'])->name('admin.postResponse');
        Route::get('/donner/delete/{user}', [App\Http\Controllers\AdminController::class, 'getDonnerDelete'])->name('admin.getDonnerDelete');

        Route::get('/blood/manage', [App\Http\Controllers\AdminController::class, 'getManageBlood'])->name('admin.getManageBlood');
        Route::post('/blood/manage', [App\Http\Controllers\AdminController::class, 'postAddDonorBlood'])->name('admin.postAddDonorBlood');
        Route::get('/issuebooold/{bloodgroup}', [App\Http\Controllers\AdminController::class, 'getIssueBlood'])->name('admin.getIssueBlood');
        Route::post('/issueblood', [App\Http\Controllers\AdminController::class, 'postIsssueBlood'])->name('admin.postIsssueBlood');
        Route::get('/user/manage', [App\Http\Controllers\AdminController::class, 'getManageAdminUser'])->name('admin.getManageAdminUser');
        Route::post('/user/manage', [App\Http\Controllers\AdminController::class, 'postAddAdminUser'])->name('admin.postAddAdminUser');
        Route::get('/user/delete/{user}', [App\Http\Controllers\AdminController::class, 'getAdminUserDelete'])->name('admin.getAdminUserDelete');
        Route::get('/blood-lists/{type}', [App\Http\Controllers\AdminController::class, 'getbloodlist'])->name('admin.getbloodlist');
        Route::get('/blood-request/{type}', [App\Http\Controllers\AdminController::class, 'getListfofDonnorToRequest'])->name('admin.getListfofDonnorToRequest');
        Route::post('/blood-request/{type}', [App\Http\Controllers\AdminController::class, 'postListfofDonnorToRequest'])->name('admin.postListfofDonnorToRequest');
        Route::get('/bloodbank', [BloodBankController::class, 'index'])->name('bloodbank.index');
        Route::get('/bloodbank/create', [BloodBankController::class, 'create'])->name('bloodbank.create');
        Route::get('/bloodbank/{id}', [BloodBankController::class, 'show'])->name('bloodbank.show');
        Route::post('/bloodbank', [BloodBankController::class, 'store'])->name('bloodbank.store');
        Route::put('/bloodbank/{id}', [BloodBankController::class, 'update'])->name('bloodbank.update');
        Route::delete('/bloodbank/{id}', [BloodBankController::class, 'destroy'])->name('bloodbank.destroy');
        Route::get('/bloodbank/{id}', [BloodBankController::class, 'edit'])->name('bloodbank.edit');
    }

);

Route::get('test', function () {
    $UserCoord = array(); //stores user coord;
    $location = 'Purtimkanda';
    $bloodcoord = BloodBank::select('lat', 'lon', 'name')->get();

    //find user coord
    $url = "http://nominatim.openstreetmap.org/";
    $nominatim = new Nominatim($url);

    $search = $nominatim->newSearch()
        ->country('Nepal')
        ->city($location)
        ->polygon('geojson')    //or 'kml', 'svg' and 'text'
        ->addressDetails();

    $result = $nominatim->find($search);


    array_push($UserCoord, $result[0]['lat'], $result[0]['lon']); //gather user coord


    //haversine
    function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // radius of the earth in kilometers


        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c; // distance in kilometers

        return $distance;
    }

    $bestDistance = INF;
    $closestLocationName = "";

    foreach ($bloodcoord as $blood) {
        $distance = haversineDistance($UserCoord[0], $UserCoord[1], $blood['lat'], $blood['lon']);

        if ($distance < $bestDistance) {
            $bestDistance = $distance;
            $closestLocationName = $blood['name'];
        }
    }

    return "Our location " . $location . ', Nearest blood bank ' . $closestLocationName;
});
