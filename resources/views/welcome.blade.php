@extends('layouts.home')
@inject('getProfile','App\Http\Controllers\ProfilesCont')
@inject('encode', 'App\Http\Controllers\AdminsCont')
@inject('user', 'Illuminate\Foundation\Auth\User')
@inject('posts', 'App\Http\Controllers\PostsCont')
@inject('getInfo', 'App\Http\Controllers\AdminsCont')

@section('homeSlides')

<div id="slide-home">
 <div id="slides-container">
   		 <div id="slides" data-0="transform:translate(0%,0%);"
			    data-50p=""
			    data-150p="transform:translate(0%,-50%);"
			    data-200p=""
			    data-300p="transform:translate(-50%,-50%);"
			    data-350p=""
			    data-450p="transform:translate(-50%,0%);">
   		 	<div id="slide-1" class="slide" style="background-color: #f96332">
   		 		<div class="caption">
				    <h1>{{ $getInfo->getValue('orangetitle') }}</h1>
				    <p>{{ $getInfo->getValue('orangetext') }}</p>
				</div>
   		 	</div>
	        <div id="slide-2" class="slide" style="background: url('{{ (($getInfo->getValue('image1')) ? $getInfo->getValue('image1') : '/assets/img/slide.png') }}') no-repeat center center;"
	        	>
	        	<div class="caption" data-130p="opacity: 0; transform:translate(0px,-200%);"
    data-180p="opacity: 1; transform:translate(0px,0px);"
    data-250p=""
    data-280p="opacity: 0; transform:translate(-100px,0px);"
    data-anchor-target="#helper">
				    <h1>{{ $getInfo->getValue('image1title') }}</h1>
				    <p>{{ $getInfo->getValue('image1text') }}</p>
				</div>
	        </div>
	        <div id="slide-3" class="slide" style="background: url('{{ (($getInfo->getValue('image2')) ? $getInfo->getValue('image2') : '/assets/img/slide-2.png') }}') no-repeat center center;">
	        	<div class="caption" data-250p="opacity: 0; transform:translate(300px,0px);"
    data-300p="opacity: 1; transform:translate(0px,0px);"
    data-anchor-target="#helper">
				    <h1>{{ $getInfo->getValue('image2title') }}</h1>
				    <p>{{ $getInfo->getValue('image2text') }}</p>
				</div>
	        </div>
	        <div id="slide-4" class="slide" style="background: url('{{ (($getInfo->getValue('image3')) ? $getInfo->getValue('image3') : '/assets/img/slide-3.png') }}') no-repeat center center;">
	        	<div class="caption" data-430p="opacity: 0;"
    data-450p="opacity: 1;"
    data-anchor-target="#helper">
				    <h1>{{ $getInfo->getValue('image3title') }}</h1>
				    <p>{{ $getInfo->getValue('image3text') }}</p>
				</div>
	        </div>
   		 </div>
	</div>
<div id="helper">
    <div class="marker"></div>
    <div class="marker"></div>
    <div class="marker"></div>
    <div class="marker"></div>
</div>
</div>


<!-- Include Skrollr.js -->
<script src="/assets/js/skrollr.min.js"></script>
<script type="text/javascript">
    var s = skrollr.init();
</script>
@endsection
