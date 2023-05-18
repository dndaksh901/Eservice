@extends('layouts.app')

@section('content')
<style>

#search{
    margin: 20px 0;
}
.grid {
    position: relative;
    width: 100%;
    background: #fff;
    color: #666666;
    border-radius: 2px;
    margin-bottom: 25px;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.1);
}

.grid .grid-body {
    padding: 15px 20px 15px 20px;
    font-size: 0.9em;
    line-height: 1.9em;
}

.search table tr td.rate {
    color: #f39c12;
    line-height: 50px;
}

.search table tr:hover {
    cursor: pointer;
}

.search table tr td.image {
	width: 50px;
}

.search table tr td img {
	width: 50px;
	height: 50px;
}

.search table tr td.rate {
	color: #f39c12;
	line-height: 50px;
}

.search table tr td.price {
	font-size: 1.5em;
	line-height: 50px;
}

.search #price1,
.search #price2 {
	display: inline;
	font-weight: 600;
}
.pagination {
    position: relative;
    transform: translate(-50%, -50%);
    margin: 0;
    padding: 10px;
    background-color: #fff;
    border-radius: 40px;
    box-shadow: 0 5px 25px 0 rgba(0, 0, 0, 0.5);
    width: fit-content;
    left: 50%;
    top: 30px;
}
.pagination li {
  display: inline-block;
  list-style: none;
}
.pagination li a {
  display: block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  background-color: #fff;
  text-align: center;
  text-decoration: none;
  color: #252525;
  border-radius: 4px;
  margin: 5px;
  box-shadow: inset 0 5px 10px rgba(0, 0, 0, 0.1), 0 2px 5px rgba(0, 0, 0, 0.5);
  transition: all 0.3s ease;
}
.pagination li a:hover, .pagination li a.active {
  color: #fff;
  background-color: var(--yellow-color);
}
.pagination li:first-child a {
  border-radius: 40px 0 0 40px;
}
.pagination li:last-child a {
  border-radius: 0 40px 40px 0;
}


.nav>li>a.userdd {
    padding: 5px 15px
}
.userprofile {
	width: 100%;
	float: left;
	clear: both;
	margin: 12px auto
}
.userprofile .userpic {
	height: 100px;
	width: 100px;
	clear: both;
	margin: 0 auto;
	display: block;
	border-radius: 100%;
	box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-ms-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	position: relative;
}
.userprofile .userpic .userpicimg {
	height: auto;
	width: 100%;
	border-radius: 100%;
}
.username {
	font-weight: 400;
	font-size: 20px;
	line-height: 20px;
	color: #000000;
	margin-top: 20px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.username+p {
	color: #607d8b;
	font-size: 13px;
	line-height: 15px;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
}
.settingbtn {
	height: 30px;
	width: 30px;
	border-radius: 30px;
	display: block;
	position: absolute;
	bottom: 0px;
	right: 0px;
	line-height: 30px;
	vertical-align: middle;
	text-align: center;
	padding: 0;
	box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
	-ms-box-shadow: 0px 2px 5px 0 rgba(0, 0, 0, 0.15);
}
.userprofile.small {
	width: auto;
	clear: both;
	margin: 0px auto;
}
.userprofile.small .userpic {
	height: 40px;
	width: 40px;
	margin: 0 10px 0 0;
	display: block;
	border-radius: 100%;
	box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-moz-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-webkit-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	-ms-box-shadow: 0px 3px 10px 0 rgba(0, 0, 0, 0.15);
	position: relative;
	float: left;
}
.userprofile.small .textcontainer {
	float: left;
	max-width: 100px;
	padding: 0
}
.userprofile.small .userpic .userpicimg {
	min-height: 100%;
	width: 100%;
	border-radius: 100%;
}
.userprofile.small .username {
	font-weight: 400;
	font-size: 16px;
	line-height: 21px;
	color: #000000;
	margin: 0px;
	float: left;
	width: 100%;
}
.userprofile.small .username+p {
	color: #607d8b;
	font-size: 13px;
	float: left;
	width: 100%;
	margin: 0;
}
/*==============================*/
/*====== Social Profile css =====*/
/*==============================*/
.countlist h3 {
	margin: 0;
	font-weight: 400;
	line-height: 28px;
}
.countlist {
	text-transform: uppercase
}
.countlist li {
	padding: 15px 30px 15px 0;
	font-size: 14px;
	text-align: left;
}
.countlist li small {
	font-size: 12px;
	margin: 0
}
.followbtn {
	float: right;
	margin: 22px;
}
.userprofile.social {
	background: url(http://placehold.it/500x300) no-repeat top center;
	background-size: 100%;
	padding: 50px 0;
	margin: 0
}
.userprofile.social .username {
	color: #ffffff
}
.userprofile.social .username+p {
	color: #ffffff;
	opacity: 0.8
}
.postbtn {
	position: absolute;
	right: 5px;
	top: 5px;
	z-index: 9
}
.status-upload {
	width: 100%;
	float: left;
	margin-bottom: 15px
}
.posttimeline .panel {
	margin-bottom: 15px
}
.commentsblock {
	background: #f8f9fb;
}
.nopaddingbtm {
	margin-bottom: 0
}
/*==============================*/
/*====== Recently connected  heading =====*/
/*==============================*/
.memberblock {
	width: 100%;
	float: left;
	clear: both;
	margin-bottom: 15px
}
.member {
	width: 24%;
	float: left;
	margin: 2px 1% 2px 0;
	background: #ffffff;
	border: 1px solid #d8d0c3;
	padding: 3px;
	position: relative;
	overflow: hidden
}
.memmbername {
	position: absolute;
	bottom: -30px;
	background: rgba(0, 0, 0, 0.8);
	color: #ffffff;
	line-height: 30px;
	padding: 0 5px;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
	width: 100%;
	font-size: 11px;
	transition: 0.5s ease all;
}
.member:hover .memmbername {
	bottom: 0
}
.member img {
	width: 100%;
	transition: 0.5s ease all;
}
.member:hover img {
	opacity: 0.8;
	transform: scale(1.2)
}

.panel-default>.panel-heading {
    color: #607D8B;
    background-color: #ffffff;
    font-weight: 400;
    font-size: 15px;
    border-radius: 0;
    border-color: #e1eaef;
}



.btn-circle {
    width: 30px;
    height: 30px;
    padding: 6px 0;
    border-radius: 15px;
    text-align: center;
    font-size: 12px;
    line-height: 1.428571429;
}

.page-header.small {
    position: relative;
    line-height: 22px;
    font-weight: 400;
    font-size: 20px;
}

.favorite i {
    color: #eb3147;
}

.btn i {
    font-size: 17px;
}

.panel {
    box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
    -moz-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
    -webkit-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
    -ms-box-shadow: 0px 2px 10px 0 rgba(0, 0, 0, 0.05);
    transition: all ease 0.5s;
    -moz-transition: all ease 0.5s;
    -webkit-transition: all ease 0.5s;
    -ms-transition: all ease 0.5s;
    margin-bottom: 35px;
    border-radius: 0px;
    position: relative;
    border: 0;
    display: inline-block;
    width: 100%;
}

.panel-footer {
    padding: 10px 15px;
    background-color: #ffffff;
    border-top: 1px solid #eef2f4;
    border-bottom: 2px solid #ffc107;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    color: #607d8b;
}



.connect-detail{
    text-decoration: none;
    color: #212529;
    font-weight: 600;
}
@media only screen and (max-width: 460px) {
    #filter-section{
    display: none;
    }
}
</style>
  <div class="main-content" id="search">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container-fluid">
<div class="row">

  <!-- BEGIN SEARCH RESULT -->
  <div class="col-md-12">
    <div class="grid search">
      <div class="grid-body">
        <div class="row">
          <!-- BEGIN FILTERS -->
          <div class="col-md-3">
            <h2 class="grid-title"><i class="fa fa-filter"></i> Filters</h2>
            <hr>

            <!-- BEGIN FILTER BY CATEGORY -->
            <h4 class="filter-section my-3">Select Categories:</h4>
            <div class="my-3" id="filter-section">
            @foreach ($occupations as $occupation)
            <div class="custom-control custom-radio">
                <input type="radio" class="icheck custom-control-input" id="occupation_id.{{$occupation->id}}" name="occupation_id" value="{{$occupation->id}}">
                <label class="custom-control-label" for="occupation_id.{{$occupation->id}}">{{ $occupation->occupation_name	 }}</label>
              </div>
              @endforeach
            </div>

            <!-- END FILTER BY CATEGORY -->
          </div>
          <!-- END FILTERS -->

          <!-- BEGIN RESULT -->
          <div class="col-md-9">
            <h2><i class="fa fa-file-o"></i> Result</h2>
            <hr>

            <!-- BEGIN SEARCH INPUT -->
            <div class="input-group">
              <input type="text" class="form-control" id="search-text">
              <span class="input-group-btn">
                <button class="btn btn-yellow" type="button" onclick="searchworker()" id="search-btn" disabled><i class="fa fa-search"></i></button>
              </span>
            </div>
            <!-- END SEARCH INPUT -->
            <p>Showing all results matching <strong>{{  isset($search_occupation) ? $search_occupation->occupation_name : 'No Found' }}, {{ $city}}, {{ $state}}</strong></p>

            <div class="padding"></div>

            <div class="row">
              <!-- BEGIN ORDER RESULT -->
              <div class="col-sm-6">
                <div class="btn-group">
                  {{-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Order by <span class="caret"></span>
                  </button> --}}
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Name</a></li>
                    <li><a href="#">Date</a></li>
                    <li><a href="#">View</a></li>
                    <li><a href="#">Rating</a></li>
                  </ul>
                </div>
              </div>
              <!-- END ORDER RESULT -->

              {{-- <div class="col-md-6 text-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default active"><i class="fa fa-list"></i></button>
                  <button type="button" class="btn btn-default"><i class="fa fa-th"></i></button>
                </div>
              </div> --}}
            </div>

                <div class="container">
                    <div class="row">

                        @if(isset($profiles))
                        @foreach ($profiles as $key=>$profile)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="panel userlist">
                              <div class="panel-body text-center">
                                <div class="userprofile">
                                  <div class="userpic"> <img src="{{ asset('vendor/vendor_image/'.$profile->vendor->avatar ?? 'avatar.jpg' )}}" alt="" class="userpicimg"> </div>
                                  <h3 class="username">{{ $profile->vendor->name ?? $profile->vendor->username }}</h3>
                                  <p>{{ $profile->city->name ?? '' }},{{ $profile->state->name ?? '' }}</p>
                                  <p>Experience: {{ $profile->experience_year }} Years, {{ $profile->experience_month }} Months</p>
                                </div>
                                <p><a href="mailto:{{ $profile->vendor->email }}" class="connect-detail">{{ $profile->vendor->email }}</a> | <a href="tel:{{ $profile->vendor->mobile }}" class="connect-detail">{{ $profile->vendor->mobile }}</a></p>
                                {{-- <div class="socials tex-center"> <a href="" class="btn btn-circle btn-primary "><i class="fa fa-facebook"></i></a> <a href="" class="btn btn-circle btn-danger "><i class="fa fa-google-plus"></i></a> <a href="" class="btn btn-circle btn-info "><i class="fa fa-twitter"></i></a> <a href="" class="btn btn-circle btn-warning "><i class="fa fa-envelope"></i></a> </div> --}}
                              </div>
                              <div class="panel-footer"> <a href="" class="btn btn-link">Connect</a>
                                {{-- <a href="" class="btn btn-link pull-right favorite"><i class="fa fa-heart-o"></i></a>  --}}
                            </div>
                            </div>
                          </div>
                          @endforeach

                          @endif
                          @if(count($profiles) == 0)
                          <div class="col-12"><b>Not Found Someone..</b></div>
                          @endif

                            @if($profiles->count())
                                <div class="row">
                                    <div class="col">
                                        {{ $profiles->links() }}
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
            </div>
            <!-- END TABLE RESULT -->


          </div>
          <!-- END RESULT -->
        </div>
      </div>
    </div>
  </div>
  <!-- END SEARCH RESULT -->
</div>
</div>
  </div>
@endsection

@push('js')

   <script>
     var location_data = JSON.parse(localStorage.getItem('currentLocation'));
        $('input:radio[name="occupation_id"]').change(
            function(){
                if ($(this).is(':checked')) {

                    let occupation = $(this).val();
                    let state = "{{ $state }}" ?? location_data.regionName;
                    let city = "{{ $city }}" ??  location_data.cityName;
                    let url ="{{ url('search') }}/"+occupation+'/'+state+'/'+city;
                    window.location.href=url;
                }
        });

        $(document).ready(function(){
            var newWindowWidth = $(window).width();
            if (newWindowWidth < 461) {
                $(".filter-section").click(function(){
                    $("#filter-section").fadeToggle('slow');

                });
            }

            $('#search-text').on('keyup', function() {
                let occupation = $('#search-text').val();
                    if(occupation.length < 3){
                    $('#search-btn').attr('disabled', 'disabled');
                    }else{
                        $('#search-btn').removeAttr("disabled");
                    }
            });

        });

        function searchworker(){
                    let occupation = $('#search-text').val();

                    if(occupation.length < 3){
                       $('#search-btn').attr('disabled', 'disabled');
                       return false;
                    }else{
                        $('#search-btn').removeAttr("disabled");
                    }

                    let state = "{{ $state }}" ?? location_data.regionName;
                    let city = "{{ $city }}" ??  location_data.cityName;
                    let url ="{{ url('search-by-name') }}/"+occupation+'/'+state+'/'+city;
                    window.location.href=url;
            }

            let search_enter = document.getElementById("search-text");
            search_enter.addEventListener("keydown", function (e) {
                if(e.keyCode == 13){ //checks whether the pressed key is "Enter"
                searchworker();

            }
         });

   </script>

@endpush
