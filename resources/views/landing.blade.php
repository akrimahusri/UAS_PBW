@extends('layouts.app')

@section('content')

<nav style="background-color: #fff; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-family: 'Poppins', sans-serif; display: flex; justify-content: space-between; align-items: center;">
    <div class="logo">
        <a href="{{ route('landing.page') }}" style="font-size: 1.5rem; font-weight: 700; color: #023047; text-decoration: none;">
            CookLab
        </a>
    </div>
    <div class="nav-links" style="display: flex; gap: 1.5rem;">
        <a href="dashboard" style="color: #023047; text-decoration: none; font-weight: 500;">Dashboard</a>
        <a href="#" style="color: #023047; text-decoration: none; font-weight: 500;">About Us</a>
        @guest
            <a href="{{ route('login') }}" style="color: #16666B; text-decoration: none; font-weight: 500;">Login</a>
            
            <a href="{{ route('register') }}" style="color: #16666B; text-decoration: none; font-weight: 500;">Sign up</a>
        @else
        
             <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();"
                style="color: #023047; text-decoration: none; font-weight: 500;">
                 Logout
             </a>
             <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
             </form>
        @endguest
    </div>
</nav>
{{-- END: Custom Navigation Bar --}}


{{-- Hero Section --}}
<section style="position: relative; padding: 5rem 2rem; background-color: #f8f9fa; font-family: 'Poppins', sans-serif; overflow: hidden; text-align: left;">
  <img src="{{ asset('images/bakery-bg.jpeg') }}" alt="Background with bakery theme"
       style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.2; /* Opacity diubah menjadi 20% */ z-index: 0;">
  
  <div style="position: relative; max-width: 650px; margin-left: 5%; z-index: 1;">
    <h1 style="font-size: 2.7rem; font-weight: 700; color: #023047; margin-bottom: 1.5rem; line-height: 1.3;">
      Discover, Experiment, and <br>Enjoy Countless Recipes at 
      <span style="color: #219ebc;">CookLab</span>
    </h1>

    <div style="margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
      <a href="{{ route('dashboard') }}" 
         style="padding: 12px 28px; background: #219ebc; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
         onmouseover="this.style.background='#1b90aa'" onmouseout="this.style.background='#219ebc'">
         Explore Recipes
      </a>

      <a href="{{ route('register') }}" 
         style="padding: 12px 28px; background: #023047; color: white; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
         onmouseover="this.style.background='#012a3e'" onmouseout="this.style.background='#023047'">
         Create an Account
      </a>
    </div>
  </div>
</section>

{{-- Features Section ("What We Offer") --}}
<section style="background-color: #88C3C6; /* Warna background diubah kembali */ padding: 4rem 2rem; font-family: 'Poppins', sans-serif;">
  <h2 style="font-size: 2.2rem; font-weight: 700; text-align: center; color: #000; /* Warna judul kembali ke original #000 untuk kontras dengan #88C3C6 */ margin-bottom: 2rem;">What We Offer</h2>

  <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 2.5rem;">
    @php
      $features = [
        ['img' => 'recipe-icon.png', 'alt' => 'Recipes Icon', 'text' => 'Thousands of <br>Recipes'],
        ['img' => 'review-icon.png', 'alt' => 'Review Icon', 'text' => 'Experiment &<br> Review'],
        ['img' => 'access-icon.png', 'alt' => 'Access Icon', 'text' => 'Access anytime <br>& anywhere!']
      ];
    @endphp

    @foreach($features as $feature)
      <div style="background: #ffffff; border-radius: 1rem; padding: 2rem 1.5rem; width: 260px; text-align: center; box-shadow: 0 6px 12px rgba(0,0,0,0.08); transition: transform 0.3s;"
           onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.12)';" 
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.08)';">
        <img src="{{ asset('images/' . $feature['img']) }}" alt="{{ $feature['alt'] }}" style="width: 55px; margin: 0 auto 1.5rem;">
        {{-- Warna teks card #003049 dari kode originalmu, sepertinya kontrasnya baik --}}
        <h4 style="color: #003049; font-size: 1.1rem; font-weight: 600; line-height: 1.4;">{!! $feature['text'] !!}</h4>
      </div>
    @endforeach
  </div>
  <p style="text-align: center; max-width: 600px; margin: 3rem auto 0; color: #023047; /* Atau #000 agar senada dengan judul section */ font-size: 0.95rem; line-height: 1.6;">
      These are just a few of the awesome things CookLab has to offer. Whether you're a beginner or a kitchen pro, there's always something new to try, learn, and enjoy.
  </p>
</section>

{{-- Footer Section --}}
<footer style="background-color: #70B9BE; /* Warna background diubah kembali */ font-family: 'Poppins', sans-serif; padding: 4rem 2rem 2rem; color: white; /* Warna teks utama di footer jadi putih */"> 
  <div style="max-width: 1100px; margin: auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; align-items: start;">
    
    {{-- About --}}
    <div style="text-align: left;">
      <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: white;">About CookLab</h4>
      <p style="line-height: 1.7; font-size: 0.9rem;">
        CookLab is a modern recipe platform made for everyone who loves to cook, explore, and share. 
        We aim to make cooking simple, inspiring, and accessible for all skill levels. 
        Join us and turn everyday meals into something special.
      </p>
    </div>

    {{-- Terms & Contact --}}
    <div style="text-align: left;">
      <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: white;">Terms & Privacy</h4>
      <ul style="list-style: none; padding: 0; margin: 0 0 1.5rem;">
        <li style="margin-bottom: 0.5rem;">
          <a href="#" style="color: white; text-decoration: none; font-size: 0.9rem; hover: {text-decoration: underline;}">Terms of Service</a>
        </li>
        <li>
          <a href="#" style="color: white; text-decoration: none; font-size: 0.9rem; hover: {text-decoration: underline;}">Privacy Policy</a>
        </li>
      </ul>

      <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: white;">Contact Us</h4>
      <p style="display: flex; align-items: center; gap: 0.7rem; font-size: 0.9rem; margin-bottom: 0.5rem;">
        <img src="{{ asset('images/email.png') }}" style="width: 16px; filter: brightness(0) invert(1);"> cookLab@gmail.com
      </p>
      <p style="display: flex; align-items: center; gap: 0.7rem; font-size: 0.9rem;">
        <img src="{{ asset('images/phone.png') }}" style="width: 16px; filter: brightness(0) invert(1);"> +62 8775434455
      </p>
    </div>

    {{-- Social Media --}}
    <div style="text-align: left;">
      <h4 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: white;">Follow Us</h4>
      <div style="display: flex; flex-direction: column; gap: 0.8rem;">
        <div style="display: flex; align-items: center; gap: 0.7rem;">
          <img src="{{ asset('images/ig.png') }}" style="width: 20px; filter: brightness(0) invert(1);"> 
          <span style="font-size: 0.9rem;">cooklabOfficial</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.7rem;">
          <img src="{{ asset('images/tiktok.png') }}" style="width: 20px; filter: brightness(0) invert(1);"> 
          <span style="font-size: 0.9rem;">cooklabOfficial</span>
        </div>
        <div style="display: flex; align-items: center; gap: 0.7rem;">
          <img src="{{ asset('images/youtube.png') }}" style="width: 20px; filter: brightness(0) invert(1);"> 
          <span style="font-size: 0.9rem;">cooklabOfficial</span>
        </div>
      </div>
    </div>
  </div>

  {{-- Bottom line --}}
  <div style="text-align: center; margin-top: 3.5rem; font-size: 0.8rem; opacity: 0.7; border-top: 1px solid rgba(255,255,255,0.3); /* Warna border disesuaikan agar kontras dengan #70B9BE */ padding-top: 1.5rem;">
    &copy; {{ date('Y') }} CookLab. All rights reserved.
  </div>
</footer>

@endsection