<div class="navigation-menu">
    <div class="menu-list">
        <a href="{{ route('public.account.posts') }}" class="item {{ activeMenuClass('posts') }}">
            <span class="icon icon-user"></span>My Posts
        </a>
        <a href="{{ route('public.account.profile') }}" class="item {{ activeMenuClass('profile') }}">
            <span class="icon icon-user"></span>Profile
        </a>
        <a href="{{ route('public.account.password') }}" class="item {{ activeMenuClass('password') }}">
            <span class="icon icon-key"></span>Password
        </a>
        <div class="item" tabindex="1"><span class="icon icon-bell"></span>Notifications</div>
    </div>
</div>
