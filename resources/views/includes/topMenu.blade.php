@if($getInfo->getValue('twitter'))
<li class="nav-item">
    <a class="nav-link" rel="tooltip" title="Follow us on Twitter" data-placement="bottom" href="{{ $getInfo->getValue('twitter') }}" target="_blank">
        <i class="fa fa-twitter"></i>
        <p class="d-lg-none">Twitter</p>
    </a>
</li>
@endif
@if($getInfo->getValue('facebook'))
<li class="nav-item">
    <a class="nav-link" rel="tooltip" title="Like us on Facebook" data-placement="bottom" href="{{ $getInfo->getValue('facebook') }}" target="_blank">
        <i class="fa fa-facebook-square"></i>
        <p class="d-lg-none">Facebook</p>
    </a>
</li>
@endif
@if($getInfo->getValue('instagram'))
<li class="nav-item">
    <a class="nav-link" rel="tooltip" title="Follow us on Instagram" data-placement="bottom" href="{{ $getInfo->getValue('instagram') }}" target="_blank">
        <i class="fa fa-instagram"></i>
        <p class="d-lg-none">Instagram</p>
    </a>
</li>
@endif
@if($getInfo->getValue('github'))
<li class="nav-item">
    <a class="nav-link" rel="tooltip" title="Star on GitHub" data-placement="bottom" href="{{ $getInfo->getValue('GitHub') }}" target="_blank">
        <i class="fa fa-github"></i>
        <p class="d-lg-none">GitHub</p>
    </a>
</li>
@endif
            <li class="nav-item">
              <a href="//search.reallexi.com" class="btn btn-round">Domains Validator</a>
            </li>
             <li class="nav-item">
              <a href="//home.reallexi.com" class="btn btn-round">Blog</a>
            </li>
@if (Auth::guest())
            <li class="nav-item">
              <a href="{{ route('register') }}" class="btn btn-round">Register</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('login') }}" class="btn btn-success btn-round">Login</a>
            </li>
            
            @else
            <li class="nav-item">
              <a class="nav-link" href="/dashboard"> 
              {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
              </a>
            </li>
            <li class="nav-item">
              <a class="btn btn-danger btn-round" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Logout
              </a>
              <form id="logout-form"  action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            @endif
