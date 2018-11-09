@extends('layout.menu')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('/public/css/custom.css')}}">
		<div class="row">
			<div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                    </div>
                    <div class="ibox-content ">
                        <div class="carousel slide" id="carousel2">
                            <!-- <ol class="carousel-indicators">
                                <li data-slide-to="0" data-target="#carousel2"  class="active"></li>
                                <li data-slide-to="1" data-target="#carousel2"></li>
                                <li data-slide-to="2" data-target="#carousel2" class=""></li>
                            </ol> -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img alt="image"  class="img-responsive" src="{{url('/public/img/p_big1.jpg')}}">
                                    <!-- <div class="carousel-caption">
                                        <p>This is simple caption 1</p>
                                    </div> -->
                                </div>
                                <div class="item ">
                                    <img alt="image"  class="img-responsive" src="{{url('/public/img/p_big3.jpg')}}">
                                    <!-- <div class="carousel-caption">
                                        <p>This is simple caption 2</p>
                                    </div> -->
                                </div>
                                <div class="item">
                                    <img alt="image"  class="img-responsive" src="{{url('/public/img/p_big2.jpg')}}">
                                    <!-- <div class="carousel-caption">
                                        <p>This is simple caption 3</p>
                                    </div> -->
                                </div>
                            </div>
                            <a data-slide="prev" href="#carousel2" class="left carousel-control">
                                <i class="icon-prev fa"></i>
                            </a>
                            <a data-slide="next" href="#carousel2" class="right carousel-control">
                                <i class="icon-next fa"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                	<a href="#" class="btn btn-w-m btn-start">Let's get started</a>
                </div>
            </div>
		</div>
@stop