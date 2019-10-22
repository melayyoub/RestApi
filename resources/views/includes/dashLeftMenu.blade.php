@inject('isAdmin', 'App\Http\Controllers\AdminsCont')
@inject('msgsBar', 'App\Http\Controllers\MsgsCont')
@inject('profile', 'App\Http\Controllers\ProfilesCont')
@inject('menuLinks', 'App\Http\Controllers\MenusCont')

@foreach( $menuLinks->mainMenu() as $menu )
    @if($menu->menuparent == null)
      <li class="{{ Request::is(ltrim($menu->link, '/')) ? 'active' : '' }}"  id="show-{{ $menu->id }}"> <a  href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu->name}}<i class="fa ">v</i></a>
      <ul id="menu-{{$menu->id}}" class="list-unstyled" style="display: none;">
        @foreach( $menuLinks->mainMenu() as $menu2 )
            @if( $menu->id == $menu2->menuparent )            
                <li class="{{ Request::is(ltrim($menu2->link, '/')) ? 'active' : '' }}" ><a href="{{$menu2->link}}" class="{{$menu2->class}}"> <i class="{{$menu2->iconclass}}"></i>-{{$menu2->name}}</a>
                  <ul id="menu-{{$menu2->id}}" class="list-unstyled menuTree2">
                      @foreach( $menuLinks->mainMenu() as $menu3 )
                          @if( $menu2->id == $menu3->menuparent )            
                              <li class="{{ Request::is(ltrim($menu3->link, '/')) ? 'active' : '' }}" ><small><a href="{{$menu3->link}}" class="{{$menu3->class}}"> <i class="{{$menu3->iconclass}}"></i>--{{$menu3->name}}</a></small></li>
                          @endif
                      @endforeach
                      </ul>
                </li>
            @endif
        @endforeach
        </ul>
      </li>
   @endif
@endforeach



    @foreach( $menuLinks->adminMenu() as $menu )
    @if($menu->menuparent == null)
      <script>
      $(document).ready(function(){
           var delay=1000, setTimeoutConst;
              $("#show-{{ $menu->id }}").hover( function() {
                   setTimeoutConst = setTimeout(function(){
                          $("#menu-{{ $menu->id }}").show("slow");
                   }, delay);
              }, function(){
                $("#menu-{{ $menu->id }}").hide("slow");
                   clearTimeout(setTimeoutConst );

            });
         
      });
      </script>
      @if( ($getInfo->getAdmin(Auth::user()->id) == 1 AND $getInfo->getAdminLevel() == 0) || Auth::user()->id == 1)
        <li class="{{ Request::is(ltrim($menu->link, '/')) ? 'active' : '' }}"  id="show-{{ $menu->id }}"> <a href="{{$menu->link}}" class="{{$menu->class}}"> <i class="{{$menu->iconclass}}"></i>{{$menu->name}}<i class="fa ">v</i></a>
        <ul id="menu-{{$menu->id}}" class="list-unstyled" style="display: none;">
          @foreach( $menuLinks->adminMenu() as $menu2 )
              @if( $menu->id == $menu2->menuparent )            
                  <li class="{{ Request::is(ltrim($menu2->link, '/')) ? 'active' : '' }}" ><a href="{{$menu2->link}}" class="{{$menu2->class}}"> <i class="{{$menu2->iconclass}}"></i>-{{$menu2->name}}</a>
                    <ul id="menu-{{$menu2->id}}" class="list-unstyled menuTree2">
                        @foreach( $menuLinks->adminMenu() as $menu3 )
                            @if( $menu2->id == $menu3->menuparent )            
                                <li class="{{ Request::is(ltrim($menu3->link, '/')) ? 'active' : '' }}" ><small><a href="{{$menu3->link}}" class="{{$menu3->class}}"> <i class="{{$menu3->iconclass}}"></i>--{{$menu3->name}}</a></small></li>
                            @endif
                        @endforeach
                        </ul>
                  </li>
              @endif
          @endforeach

          </ul>
        </li>
      @endif
   @endif
@endforeach
<li class="{{ Request::is('/') ? 'active' : '' }}" > <a href="http://ddkits.com/contact"> <i class="icon-mail"></i>Contact Us</a></li>
<li class="{{ Request::is('/') ? 'active' : '' }}" > <a href="http://ddkits.com/"> <i class="icon-screen"></i>Visit Us</a></li>

