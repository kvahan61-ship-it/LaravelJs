 @extends('layouts.main')
 @push('styles')
     @vite(['resources/css/auth/Reg.css'])
 @endpush
 @section('content')
     <div class="registration-container">
         <form id="regForm" action="{{ route('register.store') }}" enctype="multipart/form-data" method="post">
             @csrf

             <h2 style="text-align: center; color: #262626;">Ստեղծել հաշիվ</h2>

             <div class="avatar-preview-wrapper" id="avatar-preview">
                 <span style="color: #8e8e8e; font-size: 12px;">Նկար</span>
             </div>

             <input type="file" name="avatar" id="avatar" accept="image/*">

             <input type="text" name="name" id="name" placeholder="Անուն" required>
             <input type="text" name="sureName" id="sureName" placeholder="Ազգանուն" required>

             <select name="gender" id="gender" required>
                 <option value="">Ընտրեք սեռը</option>
                 <option value="male">Տղամարդ</option>
                 <option value="female">Կին</option>
             </select>

             <input type="email" name="email" id="email" placeholder="Էլ. հասցե" required>
             <input type="text" name="phone" id="phone" placeholder="Հեռախոսահամար" required>

             <input type="password" name="password" id="password" placeholder="Գաղտնաբառ" required>
             <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Կրկնել գաղտնաբառը" required>

             <button type="submit">Գրանցվել</button>
         </form>

         <a href="{{ route('login') }}" class="back-to-login">Արդեն ունե՞ք հաշիվ։ Մուտք գործել</a>

         <div id="message" style="margin-top: 10px;"></div>
     </div>
 @endsection
 @push('scripts')
     @vite(['resources/js/auth/Reg.js'])
 @endpush

