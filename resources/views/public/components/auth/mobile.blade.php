 <div x-data="{ openTab: 'login' }" class="py-10 md:space-y-6">
     <!-- Tab Buttons -->
     <div class="flex space-x-4 mb-6">
         <button
             :class="{ 'bg-red-800 text-white': openTab === 'login', 'bg-gray-200 text-gray-600': openTab !== 'login' }"
             @click="openTab = 'login'" class="px-4 py-2 rounded-lg font-medium focus:outline-none">
             লগইন
         </button>
         <button
             :class="{ 'bg-blue-500 text-white': openTab === 'signup', 'bg-gray-200 text-gray-600': openTab !== 'signup' }"
             @click="openTab = 'signup'" class="px-4 py-2 rounded-lg font-medium focus:outline-none">
             সাইনআপ
         </button>
     </div>

     <!-- Login Form -->
     <div x-show="openTab === 'login'" class="mt-10">
         <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl">
             আপনার একাউন্ট এ লগইন করুন
         </h1>
         <form method="POST" class="space-y-6" action="">
             @csrf
             <div>
                 <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                     আপনার ইমেইল
                 </label>
                 <input type="email" name="email" id="email"
                     class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                     placeholder="Email Address" required="" autofocus="">
             </div>
             <div>
                 <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                     আপনার পাসওয়ার্ড
                 </label>
                 <input type="password" name="password" id="password" placeholder="••••••••"
                     class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                     required="" autocomplete="off">
             </div>
             <div class="flex items-center justify-between">
                 <div class="flex items-start">
                     <div class="flex h-5 items-center">
                         <input id="remember" aria-describedby="remember" type="checkbox"
                             class="focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 h-4 w-4 rounded border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                     </div>
                     <div class="ml-3 text-sm">
                         <label for="remember" class="select-none text-gray-500 dark:text-gray-300">
                             মনে রাখুন একউন্ট এক্সেস
                         </label>
                     </div>
                 </div>
                 <a href="#" class="text-primary-600 dark:text-primary-500 text-sm font-medium hover:underline">
                     আপনার পাসওয়ার্ড ভুলে গেছেন?
                 </a>
             </div>
             <button type="submit"
                 class="w-full rounded-lg bg-red-800 px-5 py-2.5 text-center text-sm font-medium text-white outline-none hover:bg-red-900">
                 সাবমিট করুন
             </button>
         </form>
     </div>

     <!-- Signup Form -->
     <div x-show="openTab === 'signup'" class="mt-10">
         <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 dark:text-white md:text-2xl">
             নতুন একউন্ট ক্রিট করুন
         </h1>
         <form method="POST" action="http://127.0.0.1:8000/blanee:admin/signup" class="space-y-6">
             @csrf
             <div>
                 <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                     আপনার নাম
                 </label>
                 <input type="text" name="name" id="name"
                     class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                     placeholder="Full Name" required="">
             </div>
             <div>
                 <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                     আপনার ইমেইল
                 </label>
                 <input type="email" name="email" id="email"
                     class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                     placeholder="Email Address" required="">
             </div>
             <div>
                 <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                     আপনার পাসওয়ার্ড
                 </label>
                 <input type="password" name="password" id="password" placeholder="••••••••"
                     class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-gray-900 outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 sm:text-sm"
                     required="">
             </div>
             <div class="flex items-center justify-between">
                 <div class="flex items-start">
                     <div class="flex h-5 items-center">
                         <input id="remember" aria-describedby="remember" type="checkbox"
                             class="focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 h-4 w-4 rounded border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800">
                     </div>
                     <div class="ml-3 text-sm">
                         <label for="remember" class="select-none text-gray-500 dark:text-gray-300">
                             অবশ্যই, আমি সব নিয়ম কানন মেনে চলবো এবং অঙ্গীকার করলাম
                         </label>
                     </div>
                 </div>
             </div>
             <button type="submit"
                 class="w-full rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white outline-none hover:bg-blue-700">
                 সাবমিট করুন
             </button>
         </form>
     </div>
 </div>
