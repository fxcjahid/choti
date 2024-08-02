<div class="navigation-menu">
    <div class="menu-list">
        <a href="{{ route('public.account.posts') }}"
            class="item {{ activeMenuClass('posts') }} {{ activeMenuClass('account') }}">
            <svg viewBox="0 0 24 24"
                class="h-6 w-8 flex-shrink-0 currentColor transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            {{ trans('account.menu.my_story') }}
        </a>
        <a href="{{ route('public.account.create-story') }}" class="item {{ activeMenuClass('create-story') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                class="h-7 w-8 flex-shrink-0 currentColor transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor">
                <path
                    d="M218.31-164q-27.01 0-45.66-18.65Q154-201.3 154-228.31v-503.38q0-27.01 18.65-45.66Q191.3-796 218.31-796h318.15v52H218.31q-4.62 0-8.46 3.85-3.85 3.84-3.85 8.46v503.38q0 4.62 3.85 8.46 3.84 3.85 8.46 3.85h503.38q4.62 0 8.46-3.85 3.85-3.84 3.85-8.46v-318.15h52v318.15q0 27.01-18.65 45.66Q748.7-164 721.69-164H218.31ZM336-298v-52h268v52H336Zm0-108v-52h268v52H336Zm0-108v-52h268v52H336Zm346-106v-72h-72v-52h72v-72h52v72h72v52h-72v72h-52Z" />
            </svg>
            {{ trans('account.menu.create_new_story') }}
        </a>
        <a href="{{ route('public.account.profile') }}" class="item {{ activeMenuClass('profile') }}">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-8 flex-shrink-0 currentColor transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                <path
                    d="M7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13C9.23858 13 7 10.7614 7 8ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z"
                    fill="currentColor"></path>
                <path
                    d="M6.34315 16.3431C4.84285 17.8434 4 19.8783 4 22H6C6 20.4087 6.63214 18.8826 7.75736 17.7574C8.88258 16.6321 10.4087 16 12 16C13.5913 16 15.1174 16.6321 16.2426 17.7574C17.3679 18.8826 18 20.4087 18 22H20C20 19.8783 19.1571 17.8434 17.6569 16.3431C16.1566 14.8429 14.1217 14 12 14C9.87827 14 7.84344 14.8429 6.34315 16.3431Z"
                    fill="currentColor"></path>
            </svg>
            {{ trans('account.menu.my_profile') }}
        </a>
        <a href="{{ route('public.account.password') }}" class="item {{ activeMenuClass('password') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                class="h-8 w-8 flex-shrink-0 currentColor transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor">
                <path
                    d="M360-604h240v-96q0-50-35-85t-85-35q-50 0-85 35t-35 85v96Zm99.46 488H276.31q-27.01 0-45.66-18.65Q212-153.3 212-180.31v-359.38q0-27.01 18.65-45.66Q249.3-604 276.31-604H308v-96q0-71.6 50.27-121.8Q408.53-872 480.23-872q71.69 0 121.73 50.2Q652-771.6 652-700v96h31.69q27.01 0 45.66 18.65Q748-566.7 748-539.69V-475q-12-5.46-25.89-9.19-13.88-3.73-26.11-5.73v-49.77q0-5.39-3.46-8.85t-8.85-3.46H276.31q-5.39 0-8.85 3.46t-3.46 8.85v359.38q0 5.39 3.46 8.85t8.85 3.46h158.61q3.7 13.85 10.16 27.81 6.46 13.96 14.38 24.19Zm204.62 40.31q-71.7 0-121.73-50.27-50.04-50.26-50.04-121.96 0-71.7 50.26-121.73 50.27-50.04 121.96-50.04 71.7 0 121.74 50.26 50.04 50.27 50.04 121.96 0 71.7-50.27 121.74-50.26 50.04-121.96 50.04Zm55.23-86.08 30.92-30.92L686-256.92v-84.47h-43.39v102.93l76.7 76.69ZM264-436.61V-168v-384V-436.61Z" />
            </svg>
            {{ trans('account.menu.my_password') }}
        </a>
        <div class="item" tabindex="1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                class="h-8 w-8 flex-shrink-0 currentColor transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                fill="currentColor">
                <path
                    d="M212-220.62v-51.99h40.31v-258.47q0-84.69 53.31-148.19 53.3-63.5 136.38-76.81V-806q0-15.83 11.07-26.92Q464.14-844 479.95-844q15.82 0 26.93 11.08Q518-821.83 518-806v49.92q83.08 13.31 136.38 76.81 53.31 63.5 53.31 148.19v258.47H748v51.99H212Zm268-269.07Zm-.28 381.38q-26.64 0-45.33-18.89-18.7-18.89-18.7-45.42h128.62q0 26.93-18.98 45.62-18.97 18.69-45.61 18.69Zm-175.41-164.3h351.38v-258.47q0-73.46-51.11-124.57-51.12-51.12-124.58-51.12-73.46 0-124.58 51.12-51.11 51.11-51.11 124.57v258.47Z" />
            </svg>
            {{ trans('account.menu.my_notification') }}
        </div>
    </div>
</div>
