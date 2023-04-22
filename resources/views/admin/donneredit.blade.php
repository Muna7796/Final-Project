@extends('admin.template')
@section('content') 
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('Manage Donor') }}
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
                             <form action="{{route('admin.postEditDonor', $user->id)}}" method="POST">
            @csrf()
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label>First name </label>   
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="fName" name="name" value="{{$user->name}}" ">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>Last name</label>
                        <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lName" name="lname" placeholder=" " value="{{$user->lname}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group"> 
                    <label> Gender * </label><br />
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Male" <?php if($user->gender == 'Male'){ echo 'checked'; } ?>>
                        <span class="form-check-label"> Male </span>
                        </label>
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Female"  <?php if($user->gender == 'Female'){ echo 'checked'; } ?>>
                        <span class="form-check-label"> Female</span>
                        </label>
                        <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Other"  <?php if($user->gender == 'Other'){ echo 'checked'; } ?>>
                        <span class="form-check-label"> Other</span>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Province *</label> 
                        <select id="provinceSel" name="province" class="form-control" size="1" required>
                        <option value="{{$user->province}}" selected>{{$user->province}}</option>
                        <option> Choose Province</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>District *</label> 
                        <select id="destrictsSel" name="district" class="form-control" size="1" required>
                            <option value="{{$user->district}}" selected>{{$user->district}}</option>
                            <option selected=""> Choose District</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Minicipality *</label> 
                        <select id="municipalitySel" name="minicipality" class="form-control" size="1" required>
                            <option value="{{$user->minicipality}}" selected>{{$user->minicipality}}</option>
                            <option selected=""> Choose Municipality</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                          <label>Word No *</label> 
                          <select id="wordno" name="word_no" class="form-control" size="1" required>
                            <option selected=""> Choose word</option>
                            <option value="{{$user->word_no}}" selected>{{$user->word_no}}</option>
                            <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                          <option value="6">6</option>
                                          <option value="7">7</option>
                                          <option value="8">8</option>
                                          <option value="9">9</option>
                                          <option value="10">10</option>
                                          <option value="11">11</option>
                                          <option value="12">12</option>
                                          <option value="13">13</option>
                                          <option value="14">14</option>
                                          <option value="15">15</option>
                                          <option value="16">16</option>
                                          <option value="17">17</option>
                                          <option value="18">18</option>
                                          <option value="19">19</option>
                                          <option value="20">20</option>
                                          <option value="21">21</option>
                                          <option value="22">22</option>
                                          <option value="23">23</option>
                                          <option value="24">24</option>
                                          <option value="25">25</option>
                                          <option value="26">26</option>
                                          <option value="27">27</option>
                                          <option value="28">28</option>
                                          <option value="29">29</option>
                                          <option value="30">30</option>
                                          <option value="31">31</option>
                                          <option value="32">32</option>
                                          <option value="33">33</option>
                                          <option value="34">34</option>
                          </select>
                      </div>
                    <div class="form-group col-md-4">
                      <label>City *</label>
                      <input type="text" id="city" name="city" class="form-control" required value="{{$user->city}}">
                    </div> 
                    <div class="form-group col-md-4">
                      <label>Tole *</label>
                      <input type="text" id="tole" name="tole" class="form-control" required value="{{$user->tole}}">
                    </div>
                </div>
                  
                <div class="row">
                    <div class="form-group col-md-4">
                      <label>Mobile Number *</label>
                      <input type="number" id="email" name="email" class="form-control" value="{{$user->mobile}}" required>
                     
                       
                    </div>
                    <div class="form-group col-md-4">
                        <label>Blood Group *</label>
                        <select id="blood_group" class="form-control" name="bloodgroup"  required>
                            <option value="A+" <?php if($bloodinfo->blood_group == 'A+' ){ echo 'selected'; } ?>>A+</option>
                            <option value="B+" <?php if($bloodinfo->blood_group == 'B+' ){ echo 'selected'; } ?>>B+</option>
                            <option value="O+" <?php if($bloodinfo->blood_group == 'O+' ){ echo 'selected'; } ?>>O+</option>
                            <option value="O-" <?php if($bloodinfo->blood_group == 'O-' ){ echo 'selected'; } ?>>O-</option>
                            <option value="AB+" <?php if($bloodinfo->blood_group == 'AB+' ){ echo 'selected'; } ?>>AB+</option>
                            <option value="AB-" <?php if($bloodinfo->blood_group == 'AB-' ){ echo 'selected'; } ?>>AB-</option>
                            <option value="A-" <?php if($bloodinfo->blood_group == 'A-' ){ echo 'selected'; } ?>>A-</option>
                            <option value="B-" <?php if($bloodinfo->blood_group == 'B-' ){ echo 'selected'; } ?>>B-</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Date of Birth *</label>
                        <input type="date" id="dob" name="dob" class="form-control" value="{{$bloodinfo->dob}}" required>
                      </div>
                </div>
                    
                   
                   
                  
        </div>
        <br />
        <div class="modal-footer">
        <br />
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
        </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>


@stop