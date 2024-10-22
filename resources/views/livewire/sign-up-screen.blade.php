<x-layout>
<div>
    <section class="w-full h-screen bg-cover bg-no-repeat bg-center flex flex-col items-center rounded-lg" style="background-image: url('{{ asset('path/to/your/background-image.jpg') }}')">
        <article class="flex w-full h-full">


            <aside class="w-1/2 h-full flex flex-col gap-6 items-center justify-center backdrop-blur-md bg-opacity-70 bg-gray-300 rounded-l-lg">
                <div class="flex flex-col gap-6 items-center w-4/5">
                    <div class="w-full">
                        <input wire:model="name" type="text" placeholder="الاسم...." class="w-full px-4 py-2 rounded-full bg-white text-purple-800 placeholder-purple-800 font-bold">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full">
                        <input wire:model="email" type="email" placeholder="البريد الالكتروني او رقم الهاتف ..." class="w-full px-4 py-2 rounded-full bg-white text-purple-800 placeholder-purple-800 font-bold">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full">
                        <input wire:model="phone_number" type="text" placeholder="رقم الهاتف ...." class="w-full px-4 py-2 rounded-full bg-white text-purple-800 placeholder-purple-800 font-bold">
                        @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="w-full">
                        <input wire:model="password" type="password" placeholder="كلمة المرور ...." class="w-full px-4 py-2 rounded-full bg-white text-purple-800 placeholder-purple-800 font-bold">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-2 text-right">
                        <span class="text-purple-800 font-bold">انا أوافق على الشروط وسياسة الخصوصية</span>
                        <label>
                            <input wire:model="acceptTerms" type="checkbox" class="form-checkbox text-purple-800">
                        </label>
                    </div>
                    @error('acceptTerms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                    <button wire:click="signUp" class="w-full py-2 text-white rounded-full bg-gradient-to-b from-purple-800 via-indigo-800 to-blue-600 font-normal text-lg cursor-pointer">
                        إنـــــشـــاء
                    </button>

                    <div class="flex gap-2 items-center">
                        <a  class="text-purple-800 font-bold underline">
                            تسجيل الدخول
                        </a>
                        <span class="text-purple-800 font-bold">هل لديك حساب بالفعل؟</span>
                    </div>
                </div>
            </aside>

            <aside class="w-1/2 h-full flex flex-col items-center justify-center bg-white rounded-r-lg pt-12">

            </aside>
        </article>
    </section>

    @if (session()->has('message'))
        <div class="fixed bottom-0 right-0 m-6 p-4 bg-green-500 text-white rounded-lg">
            {{ session('message') }}
        </div>
    @endif
</div>
</x-layout>
