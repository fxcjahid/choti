@extends('public.app')

@section('title', trans('account.title'))
@section('canonical', route('public.account.index'))
@section('content')
    <main class="settings bg-white dark:bg-gray-900">
        <div class="m-auto">
            <div class="bg-white margin-responsive">
                <div class="my-5 md:mt-10 border-b border-gray-100">
                    <h1 class="mb-6 text-2xl md:text-3xl text-slate-900">
                        Settings
                    </h1>
                </div>
                <div class="lg:flex lg:flex-row">
                    <div class="w-full lg:w-3/12 border-r border-gray-100">
                        @include('public.account.utility.sidebar')
                    </div>
                    <div class="w-full lg:w-9/12">
                        <div class="setting-content">
                            <!-- profile edits -->
                            <div class="profile-edits hide-d">
                                <div class="page-header">
                                    <div class="page-title">Profile Edits</div>
                                    <div class="page-description"></div>
                                </div>
                                <div class="page-body">
                                    <div class="form-area">
                                        <form autocomplete="off">
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" id="name" placeholder="Name"
                                                        value="Fxc Jahid">
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="username">Username</label>
                                                    <input type="text" name="username" id="username"
                                                        placeholder="Username" value="fxcjahid">
                                                    <div class="alert message">
                                                        https://analiq.vip/@fxcjahid</div>
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="bio">Bio</label>
                                                    <textarea name="bio" id="bio" placeholder="Write something about your self"></textarea>
                                                    <div class="alert message">Your bio will help to
                                                        increase more fans</div>
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="email">Email</label>
                                                    <input type="text" disabled name="email" id="email"
                                                        placeholder="Email" value="fxcjahi*****ail.com">
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="number">Number</label>
                                                    <input type="text" name="number" id="number"
                                                        placeholder="Phone number">
                                                </div>
                                            </div>

                                            <div class="form-submit">
                                                <button type="submit" class="btn" tabindex="1">submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Change -->
                            <div class="password-change hide-d">
                                <div class="page-header">
                                    <div class="page-title">Change Password</div>
                                    <div class="page-description">If you forgot your password, you can
                                        request a new password by logging and following the steps for
                                        'forgot password'.</div>
                                </div>
                                <div class="page-body">
                                    <div class="form-area">
                                        <form autocomplete="off">
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="password">Current Password</label>
                                                    <input type="password" name="password" id="password"
                                                        placeholder="Current Password" autocomplete="current-password">
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="new-password">New Passowrd</label>
                                                    <input type="password" name="new-password" id="new-password"
                                                        placeholder="New Passowrd" autocomplete="new-password">
                                                </div>
                                            </div>
                                            <div class="input-controls line">
                                                <div class="input-fields">
                                                    <label for="confirm-new-password">Confirm
                                                        Password</label>
                                                    <input type="password" name="confirm-new-password"
                                                        id="confirm-new-password" placeholder="Confirm New Password"
                                                        autocomplete="confirm-new-password">
                                                </div>
                                            </div>

                                            <div class="form-submit">
                                                <button type="button" class="btn" tabindex="1">submit</button>
                                            </div>

                                            <div class="form-footer">
                                                <div class="passowrd-forgot">
                                                    <a href="#" class="link">Forgot
                                                        Password?</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Subscription Price -->
                            <div class="subscription-price hide-d">
                                <div class="page-header">
                                    <div class="page-title">Subscription Price</div>
                                    <div class="page-description">Set up your subscription.</div>
                                </div>
                                <div class="page-body">
                                    <div class="form-area">
                                        <form autocomplete="off">
                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <label for="s-price">Subscription Price (Per
                                                        Month)</label>
                                                    <div class="price-tag">
                                                        <div class="input-group disable">
                                                            <div class="input-price-text">
                                                                <span>$</span>
                                                            </div>
                                                            <input type="number" maxlength="9" max="3"
                                                                class="isNumber" autocomplete="off" name="price"
                                                                id="s-price" placeholder="Set Price">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <input id="free-subscription" type="checkbox" class="switch" checked>
                                                    <label for="free-subscription">Free
                                                        Subscription</label>
                                                    <div class="alert message">If you turn on Free
                                                        Subscription your profile will make public.
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-submit">
                                                <button type="button" class="btn" tabindex="1">save</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Privacy & Security  -->
                            <div class="security hide-d">
                                <div class="page-header">
                                    <div class="page-title">Privacy & Security</div>
                                    <div class="page-description">Manage your privacy and security
                                    </div>
                                </div>
                                <div class="page-body">
                                    <div class="form-area">
                                        <form autocomplete="off">
                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <div class="title">Active Status</div>
                                                    <input type="checkbox" id="active-status" name="active-status"
                                                        class="switch">
                                                    <label for="active-status">Show Active Status
                                                        <span>(Online)</span> </label>
                                                    <div class="alert message">Allow accounts you
                                                        follow and anyone you message to see when you
                                                        were last active or are currently active</div>
                                                </div>
                                            </div>

                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <div class="title">Hide Profile</div>
                                                    <input type="checkbox" id="hide-profile" name="hide-profile"
                                                        class="switch">
                                                    <label for="hide-profile">Hide profile</label>
                                                    <div class="alert message">Your profile will hide
                                                        from (Search, Watch Explore, Explore Creators)
                                                    </div>
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Manage Blocking  -->
                            <div class="blocking hide-d">
                                <div class="page-header">
                                    <div class="page-title">Blocking</div>
                                    <div class="page-description">You can manage to block People,
                                        Countries</div>
                                </div>
                                <div class="page-body">
                                    <div class="form-area">
                                        <form autocomplete="off">
                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <div class="title">Block Users</div>
                                                    <div class="links">Edit Block List</div>
                                                    <div class="alert message">Once you block someone,
                                                        that person can no longer see any things your
                                                        Post, Photo, Video, and Message.</div>
                                                </div>
                                            </div>

                                            <div class="input-controls">
                                                <div class="input-fields">
                                                    <div class="title">Block Countries</div>
                                                    <div class="links">Edit Block List</div>
                                                    <div class="alert message">Select the countries in
                                                        which you do not want your profile to be
                                                        displayed, they will not be able to see your
                                                        profile in any section of the site.</div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- Block User  -->
                            <div class="block-user hide-d">
                                <div class="page-header">
                                    <div class="page-title">Block Users</div>
                                    <div class="page-description">Once you block someone, that person
                                        can no longer see any things your Post, Photo, Video, and
                                        Message.</div>
                                </div>
                                <div class="page-body">
                                    <div class="blcok-area">
                                        <div class="user-search">
                                            <div class="search-box">
                                                <label for="user-search" class="icon icon-search"></label>
                                                <input type="text" name="user-search" id="user-search"
                                                    placeholder="Search users">
                                            </div>
                                        </div>
                                        <div class="user-list">
                                            <div class="user-item">
                                                <div class="user-grid">
                                                    <div class="profile-image">
                                                        <img src="/test/profile-picture-40x40.jpg" alt="Profile">
                                                    </div>
                                                    <div class="profile-name">
                                                        <span>Mohammad Jahid</span>
                                                        <div class="username">@fxcjahid</div>
                                                    </div>
                                                    <div class="profile-action">
                                                        <div class="follow-link">Block</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Block Countries  -->
                            <div class="block-countries hide-d">
                                <div class="page-header">
                                    <div class="page-title">Block Countries</div>
                                    <div class="page-description">Selected the countries in which you
                                        do not want your profile to be displayed, they will not be able
                                        to see your profile in any section of the site.</div>
                                </div>
                                <div class="page-body">
                                    <div class="blcok-area">
                                        <div class="title">Hide Countries</div>
                                        <div class="input-controls toggle">
                                            <div class="input-fields">
                                                <label for="hide-countries-switch">On</label>
                                                <input id="hide-countries-switch" type="checkbox" class="switch" checked>
                                            </div>
                                        </div>
                                        <div class="alert message">Your profile will hide from those
                                            countries.</div>
                                        <div class="control-toggle hide-d">
                                            <div class="user-search">
                                                <div class="search-box">
                                                    <label for="user-search" class="icon icon-search"></label>
                                                    <input type="text" name="user-search" id="user-search"
                                                        placeholder="Search Country">
                                                </div>
                                            </div>
                                            <div class="hide-countries-list">
                                                <div class="hide-countries-item">
                                                    <div class="tags round">
                                                        <div class="body">
                                                            Bangladesh
                                                        </div>
                                                        <div class="close icon icon-close"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="blcok-area">
                                        <div class="title">Show Countries</div>
                                        <div class="input-controls toggle">
                                            <div class="input-fields">
                                                <label for="hide-countries-switch">off</label>
                                                <input id="hide-countries-switch" type="checkbox" class="switch">
                                            </div>
                                        </div>
                                        <div class="alert message">Your profile will show only those
                                            countries.</div>
                                        <div class="control-toggle hide-dd">
                                            <div class="user-search">
                                                <div class="search-box">
                                                    <label for="user-search" class="icon icon-search"></label>
                                                    <input type="text" name="user-search" id="user-search"
                                                        placeholder="Search Country">
                                                </div>
                                            </div>
                                            <div class="hide-countries-list">
                                                <div class="hide-countries-item">
                                                    <div class="tags round">
                                                        <div class="body">
                                                            Bangladesh
                                                        </div>
                                                        <div class="close icon icon-close"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Notification  -->
                            <div class="notification hide-d">
                                <div class="page-header">
                                    <div class="page-title">Notification</div>
                                    <div class="page-description">We may still send you some important
                                        notifications about your account outside of your notification
                                        settings.</div>
                                </div>
                                <div class="page-body">
                                    <div class="notification-area">
                                        <section class="item">
                                            <div class="title">Browser Notifications</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <label for="brs-nty">On</label>
                                                    <input id="brs-nty" type="checkbox" class="switch" checked>
                                                </div>
                                            </div>
                                            <div class="alert message">Activate browser notifications
                                                to receive our alerts directly to on your
                                                mobile/browser.</div>
                                        </section>

                                        <section class="item row-block">
                                            <div class="title">Reactions</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <input id="rctn-off" type="radio" name="reactions">
                                                    <label for="rctn-off">Off</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="rctn-subr" type="radio" name="reactions">
                                                    <label for="rctn-subr">From my subscribers</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="rctn-evryne" type="radio" name="reactions" checked>
                                                    <label for="rctn-evryne">From Everyone</label>
                                                </div>
                                            </div>
                                        </section>

                                        <section class="item row-block">
                                            <div class="title">Comments</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <input id="cmnt-off" type="radio" name="comments">
                                                    <label for="cmnt-off">Off</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="cmnt-subr" type="radio" name="comments">
                                                    <label for="cmnt-subr">From my subscribers</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="cmnt-evryne" type="radio" name="comments" checked>
                                                    <label for="cmnt-evryne">From Everyone</label>
                                                </div>
                                            </div>
                                        </section>

                                        <section class="item row-block">
                                            <div class="title">Tips</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <input id="tips-off" type="radio" name="tips" checked>
                                                    <label for="tips-off">Off</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="tips-on" type="radio" name="tips">
                                                    <label for="tips-on">On</label>
                                                </div>
                                            </div>
                                        </section>

                                        <section class="item row-block">
                                            <div class="title">Mute Everyone Message</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <input id="message-off" type="radio" name="message" checked>
                                                    <label for="message-off">Off</label>
                                                </div>
                                                <div class="input-fields">
                                                    <input id="message-on" type="radio" name="message">
                                                    <label for="message-on">On</label>
                                                </div>
                                            </div>
                                        </section>

                                    </div>

                                </div>
                            </div>

                            <!-- Display -->
                            <div class="display hide-dd">
                                <div class="page-header">
                                    <div class="page-title">Display</div>
                                    <div class="page-description">Customize your view</div>
                                </div>
                                <div class="page-body">
                                    <div class="display-area">
                                        <section class="item">
                                            <div class="title">Dark/Light Mode</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <label for="brs-nty">Light</label>
                                                    <input id="brs-nty" type="checkbox" class="switch" checked>
                                                </div>
                                            </div>
                                            <div class="alert message">Changes the color scheme for
                                                Fansly for easy browsing in all settings!</div>
                                        </section>

                                        <section class="item">
                                            <div class="title">Language</div>
                                            <div class="input-controls toggle">
                                                <div class="input-fields">
                                                    <select name="select">
                                                        <option value="valor1">Valor 1</option>
                                                        <option value="valor2" selected>Valor 2
                                                        </option>
                                                        <option value="valor3">Valor 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="alert message">Analiq is available in multiple
                                                Languages.<br>select the language you wish to view the
                                                website in!</div>
                                        </section>


                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
