@extends('admin.template')
@section('content') 
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                List of {{$type}} blood11
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('message'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-primary" role="alert">
                                        {{ session('message') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
        
                            <form action="{{route('admin.postListfofDonnorToRequest', $type)}}" method="POST">
                                @csrf()
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"> (All)</th>
                                        <th>Blood Group</th>
                                        
                                        <th>Donnor</th>
                                        <th>Mobile Number</th>

                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bloods as $blood)
                                   
                                         @php
                                            $user = App\Models\User::where('id',$blood->user_id)->limit(1)->first();
                                            $distance = App\Models\Distance::getDistanceBetweenPointsNew(27.701088056754184, 85.3790029625206, $user->lat, $user->lng);
                                            
                                            
                                            $checklatestdonatedate = App\Models\Donated::where('user_id', $user->id)->limit(1)->first();
                                            if($checklatestdonatedate){
                                                if($checklatestdonatedate->donate_date < date('Y-m-d', strtotime('-3 months'))){
                                                $status = 'true';
                                                
                                                }
                                                else{
                                                    $status = 'false';

                                                }
                                            }
                                            else{
                                                $status = 'true';
                                            }
                                         @endphp
                                        @if($user->is_admin == 0)
                                        <tr>
                                            <td>
                                                @if($status == 'true')
                                                <input type="checkbox" name="checked[]" value="{{$user->email}}">
                                                @else
                                                    inability to donate
                                                @endif
                                            </td>
                                            <td>{{$blood->blood_group}}</td>
                                           
                                            <td>
                                                @if($blood->user_id != Null)
                                                    
                                                    {{ $user->name}} {{$user->lname}} ({{$distance}} Km near) 
                                                 @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                               {{$user->province}}, {{$user->district}}, {{$user->minicipality}}-{{$user->word_no}}
                                            </td>
                                        </tr>
                                        <input type="hidden" name="mobilenumber[]" value="{{$user->email}}">
                                        
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Request Blood Donation via SMS">
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@stop
@section('js')
 <script type="text/javascript">
    $(document).ready(function() {
    $('#select-all').click(function() {
        var checked = this.checked;
        $('input[type="checkbox"]').each(function() {
        this.checked = checked;
    });
    })
});
 </script>
        
@stop