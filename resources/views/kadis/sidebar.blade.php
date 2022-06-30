<nav id="sidebar">
    <div class="sidebar_blog_1">
       <div class="sidebar-header">
          <div class="logo_section">
             {{-- <a href="index.html"><img class="logo_icon img-responsive" src="{{asset('master/images/logo/logo_icon.png')}}" alt="#" /></a> --}}
          </div>
       </div>
       <div class="sidebar_user_info">
          <div class="icon_setting"></div>
          <div class="user_profle_side">
             {{-- <div class="user_img"><img class="img-responsive" src="{{asset('master/images/layout_img/user_img.jpg')}}" alt="#" /></div> --}}
             <div class="user_info">
                <h6>{{auth()->user()->nama}}</h6>
                <p><span class="online_animation"></span> Online</p>
             </div>
          </div>
       </div>
    </div>
    <div class="sidebar_blog_2">
       <h4>Kadis {{Auth()->user()->instansi->nama}}</h4>
       <ul class="list-unstyled components">
          <li class="active">
             <a href="{{route('kadis-dokumen')}}" aria-expanded="false"><i class="fa fa-check-circle green_color"></i> <span>Verifikasi Dokumen</span></a>
          </li>
          <li><a href="{{route('kadis-statistik')}}"><i class="fa fa-area-chart red_color"></i> <span>Statistik</span></a></li>
       </ul>
    </div>
 </nav>