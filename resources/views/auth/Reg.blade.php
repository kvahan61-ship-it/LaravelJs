 @extends('layouts.main')
 @push('styles')
     @vite(['resources/css/auth/Reg.css'])
 @endpush
    @section('content')

        <div class="registration-container">
            <form id="regForm" action="{{ route('register.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <input type="file" name="avatar" id="avatar" accept="image/*">


                <input type="text" name="name" id="name" placeholder="Anun" required>
                <input type="text" name="sureName" id="sureName" placeholder="Azganun" required>

                <select name="gender" id="gender" required>
                    <option value="">Yntreq sery</option>
                    <option value="male">Tghamard</option>
                    <option value="female">Kin</option>
                </select>

                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="text" name="phone" id="phone" placeholder="Heraxosahamar" required>

                <input type="password" name="password" id="password" placeholder="Gaxtnabar" required>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Krknel gaxtnabary" required>

                <button type="submit">Grancvel</button>
            </form>

            <div id="message" style="margin-top: 10px;"></div>
        </div>
    @endsection
 @push('scripts')
     @vite(['resources/js/auth/Reg.js'])
 @endpush

