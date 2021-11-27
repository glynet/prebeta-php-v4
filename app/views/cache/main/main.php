<!DOCTYPE html>
<html lang="en" class="theme-light">
<head>
    <title>Glynet</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="static/assets/images/g-logo-200x200.png" type="image/x-icon">
    <link rel="stylesheet" href="<?=$style_url?>">
    <script src="<?=$script_url?>"></script>
</head>

<body>
<div class="app">
    <div class="left">
        <div class="menu">
            <div @click="ui.desktop.left.select('feed')" class="menu-item menu-feed selected">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="home"><rect width="24" height="24" opacity="0"/><rect x="10" y="14" width="4" height="7"/><path d="M20.42 10.18L12.71 2.3a1 1 0 0 0-1.42 0l-7.71 7.89A2 2 0 0 0 3 11.62V20a2 2 0 0 0 1.89 2H8v-9a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v9h3.11A2 2 0 0 0 21 20v-8.38a2.07 2.07 0 0 0-.58-1.44z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('explore')" class="menu-item menu-explore">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="compass"><rect width="24" height="24" opacity="0"/><polygon points="10.8 13.21 12.49 12.53 13.2 10.79 11.51 11.47 10.8 13.21"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm3.93 7.42l-1.75 4.26a1 1 0 0 1-.55.55l-4.21 1.7A1 1 0 0 1 9 16a1 1 0 0 1-.71-.31h-.05a1 1 0 0 1-.18-1l1.75-4.26a1 1 0 0 1 .55-.55l4.21-1.7a1 1 0 0 1 1.1.25 1 1 0 0 1 .26.99z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('myprofile')" class="menu-item menu-myprofile">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"/><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"/><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('search')" class="menu-item menu-search">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"/><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('messages')" class="menu-item menu-messages">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="message-circle"><rect width="24" height="24" opacity="0"/><path d="M19.07 4.93a10 10 0 0 0-16.28 11 1.06 1.06 0 0 1 .09.64L2 20.8a1 1 0 0 0 .27.91A1 1 0 0 0 3 22h.2l4.28-.86a1.26 1.26 0 0 1 .64.09 10 10 0 0 0 11-16.28zM8 13a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm4 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm4 0a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('createpost')" class="menu-item menu-createpost">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="plus"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('activities')" class="menu-item menu-activities">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="clock"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm4 11h-4a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v3h3a1 1 0 0 1 0 2z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('bookmarks')" class="menu-item menu-bookmarks">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="star"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"/><path d="M17.56 21a1 1 0 0 1-.46-.11L12 18.22l-5.1 2.67a1 1 0 0 1-1.45-1.06l1-5.63-4.12-4a1 1 0 0 1-.25-1 1 1 0 0 1 .81-.68l5.7-.83 2.51-5.13a1 1 0 0 1 1.8 0l2.54 5.12 5.7.83a1 1 0 0 1 .81.68 1 1 0 0 1-.25 1l-4.12 4 1 5.63a1 1 0 0 1-.4 1 1 1 0 0 1-.62.18z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('premium')" class="menu-item menu-premium">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"/><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></g></g></svg>
                </div>
            </div>
            <div @click="ui.desktop.left.select('settings')" class="menu-item menu-settings">
                <div class="item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="settings-2"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><circle cx="12" cy="12" r="1.5"/><path d="M20.32 9.37h-1.09c-.14 0-.24-.11-.3-.26a.34.34 0 0 1 0-.37l.81-.74a1.63 1.63 0 0 0 .5-1.18 1.67 1.67 0 0 0-.5-1.19L18.4 4.26a1.67 1.67 0 0 0-2.37 0l-.77.74a.38.38 0 0 1-.41 0 .34.34 0 0 1-.22-.29V3.68A1.68 1.68 0 0 0 13 2h-1.94a1.69 1.69 0 0 0-1.69 1.68v1.09c0 .14-.11.24-.26.3a.34.34 0 0 1-.37 0L8 4.26a1.72 1.72 0 0 0-1.19-.5 1.65 1.65 0 0 0-1.18.5L4.26 5.6a1.67 1.67 0 0 0 0 2.4l.74.74a.38.38 0 0 1 0 .41.34.34 0 0 1-.29.22H3.68A1.68 1.68 0 0 0 2 11.05v1.89a1.69 1.69 0 0 0 1.68 1.69h1.09c.14 0 .24.11.3.26a.34.34 0 0 1 0 .37l-.81.74a1.72 1.72 0 0 0-.5 1.19 1.66 1.66 0 0 0 .5 1.19l1.34 1.36a1.67 1.67 0 0 0 2.37 0l.77-.74a.38.38 0 0 1 .41 0 .34.34 0 0 1 .22.29v1.09A1.68 1.68 0 0 0 11.05 22h1.89a1.69 1.69 0 0 0 1.69-1.68v-1.09c0-.14.11-.24.26-.3a.34.34 0 0 1 .37 0l.76.77a1.72 1.72 0 0 0 1.19.5 1.65 1.65 0 0 0 1.18-.5l1.34-1.34a1.67 1.67 0 0 0 0-2.37l-.73-.73a.34.34 0 0 1 0-.37.34.34 0 0 1 .29-.22h1.09A1.68 1.68 0 0 0 22 13v-1.94a1.69 1.69 0 0 0-1.68-1.69zM12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5z"/></g></g></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="center">
        <div class="content">
            <div class="header">
                <div class="header-left">
                    <div @click="app.open('feed')" class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"/><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></g></g></svg>
                    </div>
                </div>
                <div class="header-right">
                    <div @click="ui.desktop.dropdown.type.themes();" class="header-button hdr-btn-themes" data-title="Görünüm">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="moon"><rect width="24" height="24" opacity="0"/><path d="M12.3 22h-.1a10.31 10.31 0 0 1-7.34-3.15 10.46 10.46 0 0 1-.26-14 10.13 10.13 0 0 1 4-2.74 1 1 0 0 1 1.06.22 1 1 0 0 1 .24 1 8.4 8.4 0 0 0 1.94 8.81 8.47 8.47 0 0 0 8.83 1.94 1 1 0 0 1 1.27 1.29A10.16 10.16 0 0 1 19.6 19a10.28 10.28 0 0 1-7.3 3z"/></g></g></svg>
                        </div>
                    </div>
                    <div @click="app.copyClipboard(window.location.href, 0)" class="header-button hdr-btn-copy-link" data-title="Bağlantıyı kopyala">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="link-2"><rect width="24" height="24" opacity="0"/><path d="M13.29 9.29l-4 4a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4-4a1 1 0 0 0-1.42-1.42z"/><path d="M12.28 17.4L11 18.67a4.2 4.2 0 0 1-5.58.4 4 4 0 0 1-.27-5.93l1.42-1.43a1 1 0 0 0 0-1.42 1 1 0 0 0-1.42 0l-1.27 1.28a6.15 6.15 0 0 0-.67 8.07 6.06 6.06 0 0 0 9.07.6l1.42-1.42a1 1 0 0 0-1.42-1.42z"/><path d="M19.66 3.22a6.18 6.18 0 0 0-8.13.68L10.45 5a1.09 1.09 0 0 0-.17 1.61 1 1 0 0 0 1.42 0L13 5.3a4.17 4.17 0 0 1 5.57-.4 4 4 0 0 1 .27 5.95l-1.42 1.43a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l1.42-1.42a6.06 6.06 0 0 0-.6-9.06z"/></g></g></svg>
                        </div>
                    </div>
                    <div @click="ui.desktop.dropdown.type.notifications();" class="header-button hdr-btn-notifications" data-title="Bildirimler">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" opacity="0"></rect><path d="M20.52 15.21l-1.8-1.81V8.94a6.86 6.86 0 0 0-5.82-6.88 6.74 6.74 0 0 0-7.62 6.67v4.67l-1.8 1.81A1.64 1.64 0 0 0 4.64 18H8v.34A3.84 3.84 0 0 0 12 22a3.84 3.84 0 0 0 4-3.66V18h3.36a1.64 1.64 0 0 0 1.16-2.79zM14 18.34A1.88 1.88 0 0 1 12 20a1.88 1.88 0 0 1-2-1.66V18h4z"></path></svg>
                        </div>
                    </div>
                    <div class="search">
                        <div class="area">
                            <input class="search-input" type="search" placeholder="Bir şeyler arayın" id="">
                        </div>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-dropdowns">
            
                <div class="dropdown-container search-dropdown">
                    <div class="search-container">
                        <div class="search-block"></div>
                        <div class="search-content">
                            <div class="search-items"></div>
                            <div class="search-result-other fixed-item">
                                <div class="icon" data-svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"/><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"/></g></g></svg>
                                </div>
                                <div class="text">
                                    <span class="header-search-dropdown-query-keyword">glynet</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="dropdown-container themes-dropdown">
                    <div class="themes-container">
                        <div class="themes-content">
                            <div class="title">Görünüm</div>
                            <div class="content">
                                <div @click="app.setTheme(1);" class="section theme-section-dropdown-button theme-section-light-mode" selected>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="sun"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 6a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1z"/><path d="M21 11h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M6 12a1 1 0 0 0-1-1H3a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1z"/><path d="M6.22 5a1 1 0 0 0-1.39 1.47l1.44 1.39a1 1 0 0 0 .73.28 1 1 0 0 0 .72-.31 1 1 0 0 0 0-1.41z"/><path d="M17 8.14a1 1 0 0 0 .69-.28l1.44-1.39A1 1 0 0 0 17.78 5l-1.44 1.42a1 1 0 0 0 0 1.41 1 1 0 0 0 .66.31z"/><path d="M12 18a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-2a1 1 0 0 0-1-1z"/><path d="M17.73 16.14a1 1 0 0 0-1.39 1.44L17.78 19a1 1 0 0 0 .69.28 1 1 0 0 0 .72-.3 1 1 0 0 0 0-1.42z"/><path d="M6.27 16.14l-1.44 1.39a1 1 0 0 0 0 1.42 1 1 0 0 0 .72.3 1 1 0 0 0 .67-.25l1.44-1.39a1 1 0 0 0-1.39-1.44z"/><path d="M12 8a4 4 0 1 0 4 4 4 4 0 0 0-4-4z"/></g></g></svg>
                                    </div>
                                    <div class="text">
                                        <span>Aydınlık</span>
                                    </div>
                                </div>
                                <div @click="app.setTheme(2);" class="section theme-section-dropdown-button theme-section-dark-mode">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="moon"><rect width="24" height="24" opacity="0"/><path d="M12.3 22h-.1a10.31 10.31 0 0 1-7.34-3.15 10.46 10.46 0 0 1-.26-14 10.13 10.13 0 0 1 4-2.74 1 1 0 0 1 1.06.22 1 1 0 0 1 .24 1 8.4 8.4 0 0 0 1.94 8.81 8.47 8.47 0 0 0 8.83 1.94 1 1 0 0 1 1.27 1.29A10.16 10.16 0 0 1 19.6 19a10.28 10.28 0 0 1-7.3 3z"/></g></g></svg>
                                    </div>
                                    <div class="text">
                                        <span>Karanlık</span>
                                    </div>
                                </div>
                                <div @click="app.setTheme(3);" class="section theme-section-dropdown-button theme-section-system-mode">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="settings-2"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><circle cx="12" cy="12" r="1.5"/><path d="M20.32 9.37h-1.09c-.14 0-.24-.11-.3-.26a.34.34 0 0 1 0-.37l.81-.74a1.63 1.63 0 0 0 .5-1.18 1.67 1.67 0 0 0-.5-1.19L18.4 4.26a1.67 1.67 0 0 0-2.37 0l-.77.74a.38.38 0 0 1-.41 0 .34.34 0 0 1-.22-.29V3.68A1.68 1.68 0 0 0 13 2h-1.94a1.69 1.69 0 0 0-1.69 1.68v1.09c0 .14-.11.24-.26.3a.34.34 0 0 1-.37 0L8 4.26a1.72 1.72 0 0 0-1.19-.5 1.65 1.65 0 0 0-1.18.5L4.26 5.6a1.67 1.67 0 0 0 0 2.4l.74.74a.38.38 0 0 1 0 .41.34.34 0 0 1-.29.22H3.68A1.68 1.68 0 0 0 2 11.05v1.89a1.69 1.69 0 0 0 1.68 1.69h1.09c.14 0 .24.11.3.26a.34.34 0 0 1 0 .37l-.81.74a1.72 1.72 0 0 0-.5 1.19 1.66 1.66 0 0 0 .5 1.19l1.34 1.36a1.67 1.67 0 0 0 2.37 0l.77-.74a.38.38 0 0 1 .41 0 .34.34 0 0 1 .22.29v1.09A1.68 1.68 0 0 0 11.05 22h1.89a1.69 1.69 0 0 0 1.69-1.68v-1.09c0-.14.11-.24.26-.3a.34.34 0 0 1 .37 0l.76.77a1.72 1.72 0 0 0 1.19.5 1.65 1.65 0 0 0 1.18-.5l1.34-1.34a1.67 1.67 0 0 0 0-2.37l-.73-.73a.34.34 0 0 1 0-.37.34.34 0 0 1 .29-.22h1.09A1.68 1.68 0 0 0 22 13v-1.94a1.69 1.69 0 0 0-1.68-1.69zM12 15.5a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5z"/></g></g></svg>
                                    </div>
                                    <div class="text">
                                        <span>Cihazıma göre</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown-container notifications-dropdown">
                    <div class="notifications-container">
                        <div class="notifications-content">
                            <div class="title">Bildirimler</div>
                            <div class="content">
                                <div class="follow-requests">
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"/><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"/><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"/><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"/></g></g></svg>
                                    </div>
                                    <div class="text">
                                        <span>Takip istekleri</span>
                                        <span>İstekleri görmek için tıklayın</span>
                                    </div>
                                </div>
                                <div class="list"></div>
                            </div>
                            <div class="empty">
                                <div class="icon">
                                    <svg id="ad6b5295-7ebf-4dc3-a7a8-a4a4b8d35fca" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 790 512.20805"><path d="M925.56335,704.58909,903,636.49819s24.81818,24.81818,24.81818,45.18181l-4.45454-47.09091s12.72727,17.18182,11.45454,43.27273S925.56335,704.58909,925.56335,704.58909Z" transform="translate(-205 -193.89598)" fill="#e6e6e6"/><path d="M441.02093,642.58909,419,576.13509s24.22155,24.22155,24.22155,44.09565l-4.34745-45.95885s12.42131,16.76877,11.17917,42.23245S441.02093,642.58909,441.02093,642.58909Z" transform="translate(-205 -193.89598)" fill="#e6e6e6"/><path d="M784.72555,673.25478c.03773,43.71478-86.66489,30.26818-192.8092,30.35979s-191.53562,13.68671-191.57335-30.028,86.63317-53.29714,192.77748-53.38876S784.68782,629.54,784.72555,673.25478Z" transform="translate(-205 -193.89598)" fill="#e6e6e6"/><rect y="509.69312" width="790" height="2" fill="#3f3d56"/><polygon points="505.336 420.322 491.459 420.322 484.855 366.797 505.336 366.797 505.336 420.322" fill="#a0616a"/><path d="M480.00587,416.35743H508.3101a0,0,0,0,1,0,0V433.208a0,0,0,0,1,0,0H464.69674a0,0,0,0,1,0,0v-1.54149A15.30912,15.30912,0,0,1,480.00587,416.35743Z" fill="#2f2e41"/><polygon points="607.336 499.322 593.459 499.322 586.855 445.797 607.336 445.797 607.336 499.322" fill="#a0616a"/><path d="M582.00587,495.35743H610.3101a0,0,0,0,1,0,0V512.208a0,0,0,0,1,0,0H566.69674a0,0,0,0,1,0,0v-1.54149A15.30912,15.30912,0,0,1,582.00587,495.35743Z" fill="#2f2e41"/><path d="M876.34486,534.205A10.31591,10.31591,0,0,0,873.449,518.654l-32.23009-131.2928L820.6113,396.2276l38.33533,126.949a10.37185,10.37185,0,0,0,17.39823,11.0284Z" transform="translate(-205 -193.89598)" fill="#a0616a"/><path d="M851.20767,268.85955a11.38227,11.38227,0,0,0-17.41522,1.15247l-49.88538,5.72709,7.58861,19.24141,45.36779-8.49083a11.44393,11.44393,0,0,0,14.3442-17.63014Z" transform="translate(-205 -193.89598)" fill="#a0616a"/><path d="M769,520.58909l21.76811,163.37417,27.09338-5.578s-3.98437-118.98157,9.56238-133.32513S810,505.58909,810,505.58909Z" transform="translate(-205 -193.89598)" fill="#2f2e41"/><path d="M778,475.58909l-10,15s-77-31.99929-77,19-4.40631,85.60944-6,88,18.43762,8.59375,28,7c0,0,11.79687-82.21884,11-87,0,0,75.53355,37.03335,89.87712,33.84591S831.60944,536.964,834,530.58909s-1-57-1-57l-47.81-14.59036Z" transform="translate(-205 -193.89598)" fill="#2f2e41"/><path d="M779.34915,385.52862l-2.85032-3.42039s-31.92361-71.82815-19.3822-91.21035,67.26762-22.23252,68.97783-21.0924-4.08488,15.9428-.09446,22.78361c0,0-42.394,9.19121-45.24435,10.33134s21.96615,43.2737,21.96615,43.2737l-2.85031,25.6529Z" transform="translate(-205 -193.89598)" fill="#ccc"/><path d="M835.21549,350.18459S805.57217,353.605,804.432,353.605s-1.71017-7.41084-1.71017-7.41084l-26.223,35.91406S763.57961,486.29929,767,484.58909s66.50531,8.11165,67.07539,3.55114-.57008-27.3631,1.14014-28.50324,29.64328-71.82811,29.64328-71.82811-2.85032-14.82168-12.54142-19.95227S835.21549,350.18459,835.21549,350.18459Z" transform="translate(-205 -193.89598)" fill="#ccc"/><path d="M855.73783,378.11779l9.121,9.69109S878.41081,499.1687,871,502.58909s-22,3-22,3l-14.35458-52.79286Z" transform="translate(-205 -193.89598)" fill="#ccc"/><circle cx="601.72966" cy="122.9976" r="26.2388" fill="#a0616a"/><path d="M800.57267,320.98789c-.35442-5.44445-7.22306-5.631-12.67878-5.68255s-11.97836.14321-15.0654-4.35543c-2.0401-2.973-1.65042-7.10032.035-10.28779s4.45772-5.639,7.18508-7.99742c7.04139-6.08884,14.29842-12.12936,22.7522-16.02662s18.36045-5.472,27.12788-2.3435c10.77008,3.84307,25.32927,23.62588,26.5865,34.99176s-3.28507,22.95252-10.9419,31.44586-25.18188,5.0665-36.21069,8.088c6.7049-9.48964,2.28541-26.73258-8.45572-31.164Z" transform="translate(-205 -193.89598)" fill="#2f2e41"/><circle cx="361.7217" cy="403.5046" r="62.98931" fill="var(--app-color)"/><path d="M524.65625,529.9355a45.15919,45.15919,0,0,1-41.25537-26.78614L383.44873,278.05757a59.83039,59.83039,0,1,1,111.87012-41.86426l72.37744,235.41211a45.07978,45.07978,0,0,1-43.04,58.33008Z" transform="translate(-205 -193.89598)" fill="var(--app-color)"/></svg>
                                </div>
                                <div class="text">
                                    <div class="top">
                                        <span>Hiç bildiriminiz yok</span>
                                    </div>
                                    <div class="desc">
                                        <span>Yeni bildirim aldığınızda burada göstereceğiz</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <main id="content"></main>
        </div>
    </div>
    <div class="right">
        <div class="details">
            <div id="box-fixed-header" class="box fixed">
                <div class="right-header">
                    <div class="user">
                        <div class="details">
                            <div @click="app.open('myprofile');" class="profile-picture pp-content">
                                <img src="img/avatar.png">
                            </div>
                        </div>
                    </div>
                    <div class="rank">
                        <div class="level-container">
                            <div class="text">
                                <span>Seviye</span><span>4 / 5</span>
                            </div>
                            <div class="road">
                                <div class="road-completed"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dynamic-right-panel"></div>

            <div id="box-trending-topics" class="box">
                <div class="title">
                    <span>Gündem</span>
                </div>
                <div class="box-content">
                    <div class="trending-topics" show-more="false">
                        <?php foreach($trending_topics['trends'] as $tt): ?>
                        <div class="trend-container <?php if ($tt['position'] > 4): ?> trendings-more <?php endif; ?>">
                            <div class="trending-up-icon">
                                <?php if ($tt['icon'] == 1): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M21 7a.78.78 0 0 0 0-.21.64.64 0 0 0-.05-.17 1.1 1.1 0 0 0-.09-.14.75.75 0 0 0-.14-.17l-.12-.07a.69.69 0 0 0-.19-.1h-.2A.7.7 0 0 0 20 6h-5a1 1 0 0 0 0 2h2.83l-4 4.71-4.32-2.57a1 1 0 0 0-1.28.22l-5 6a1 1 0 0 0 .13 1.41A1 1 0 0 0 4 18a1 1 0 0 0 .77-.36l4.45-5.34 4.27 2.56a1 1 0 0 0 1.27-.21L19 9.7V12a1 1 0 0 0 2 0V7z"></path></svg>
                                <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></svg>
                                <?php endif; ?>
                            </div>
                            <div class="trending-details">
                                <?php if ($tt['icon'] == 1): ?>
                                <span type="tag"><?=$tt['title']?></span>
                                <?php else: ?>
                                <span><?=$tt['title']?></span>
                                <?php endif; ?>
                                <span><?=$tt['description']?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <?php if ($trending_topics['count'] > 4): ?>
                        <div @click="ui.desktop.trendingTopics.more();" class="trend-show-more">
                            <div class="text">
                                <span>Daha fazlasını göster</span>
                            </div>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><path d="M12 17a1.72 1.72 0 0 1-1.33-.64l-4.21-5.1a2.1 2.1 0 0 1-.26-2.21A1.76 1.76 0 0 1 7.79 8h8.42a1.76 1.76 0 0 1 1.59 1.05 2.1 2.1 0 0 1-.26 2.21l-4.21 5.1A1.72 1.72 0 0 1 12 17z"></path></svg>
                            </div>
                        </div>
                        <div @click="ui.desktop.trendingTopics.less();" class="trend-show-less">
                            <div class="text">
                                <span>Azalt</span>
                            </div>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect><path d="M16.21 16H7.79a1.76 1.76 0 0 1-1.59-1 2.1 2.1 0 0 1 .26-2.21l4.21-5.1a1.76 1.76 0 0 1 2.66 0l4.21 5.1A2.1 2.1 0 0 1 17.8 15a1.76 1.76 0 0 1-1.59 1z"></path></svg>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="box-suggested-contacts" class="box">
                <div class="title">
                    <span>Önerilen kişiler</span>
                </div>
                <div class="box-content">
                    <div class="suggested-contacts">
                        <?php foreach($recommended_contacts as $rc): ?>
                        <div @click="app.open('profile', { username: '<?=$rc['username']?>', user_id: <?=$rc['id']?> })" class="contact contact-user-<?=$rc['id']?>">
                            <div class="avatar">
                                <img src="<?=$rc['avatar']?>">
                            </div>
                            <div class="details">
                                <div class="name">
                                    <span><?=$rc['name']?></span>
                                    <?php if ($rc['isVerified'] == true): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm4.3 7.61l-4.57 6a1 1 0 0 1-.79.39 1 1 0 0 1-.79-.38l-2.44-3.11a1 1 0 0 1 1.58-1.23l1.63 2.08 3.78-5a1 1 0 1 1 1.6 1.22z"/></g></g></svg>
                                    <?php endif; ?>
                                </div>
                                <div class="username">
                                    <span>@<?=$rc['username']?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="others">
        <div class="clipboard">
            <label>
                <input type="text" value="">
            </label>
        </div>
        <div class="bottom-alert">
            <div class="b-alert-content">
                <span></span>
            </div>
        </div>
    </div>

    <modal-area>
        <div id="profile-picture" class="modal"></div>

        <div class="modal" id="post-likes">
            <div class="modal-content" fill>
                <div class="template-5">
                    <div class="title">Gönderiyi beğenenler</div>
                    <div class="content"></div>
                    <div class="empty">
                        <div class="icon"><svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 813.30959 791.71631" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M915.60388,754.03231s.62171-13.02673,13.36643-11.51257" transform="translate(-193.3452 -54.14185)" fill="#3f3d56"/><circle cx="718.65761" cy="681.11524" r="6.37865" fill="var(--app-color)"/><rect x="717.6197" y="691.85651" width="1.80054" height="12.60376" fill="#3f3d56"/><path d="M482.565,371.06183q0,4.785-.31006,9.49a143.75416,143.75416,0,0,1-13.46972,52.19c-.06006.14-.13037.27-.18994.4-.36036.76-.73047,1.52-1.11036,2.27a142.0365,142.0365,0,0,1-7.6499,13.5,144.462,144.462,0,0,1-118.56006,66.72l1.43018,82.24,18.6499-9.82,3.33008,6.33-21.83984,11.5,2.66992,152.74.02978,2.04-14.41992,3.21.02979-2.05,4.54-246.18a144.17479,144.17479,0,0,1-102-44.38c-.90966-.94-1.81-1.91-2.68994-2.87-.04-.04-.06982-.08-.10009-.11a144.76739,144.76739,0,0,1-26.33985-40.76c.14014.16.29.31.43018.47a144.642,144.642,0,0,1,68.57959-186.38c.5-.25,1.01025-.49,1.51025-.74a144.752,144.752,0,0,1,187.52979,56.93c.88037,1.48,1.73047,2.99,2.55029,4.51A143.852,143.852,0,0,1,482.565,371.06183Z" transform="translate(-193.3452 -54.14185)" fill="#e5e5e5"/><circle cx="269.75373" cy="189.53941" r="189.53942" fill="var(--app-color)"/><path d="M323.14914,117.08381C281.99762,213.34444,326.67238,324.739,422.933,365.8905a189.55421,189.55421,0,0,0,216.04482-48.20372C597.83077,413.95024,486.43755,458.631,390.1741,417.48388S249.23,264.94364,290.377,168.68016A189.55561,189.55561,0,0,1,323.14914,117.08381Z" transform="translate(-193.3452 -54.14185)" opacity="0.2" style="isolation:isolate"/><polygon points="280.01 717.56 260.65 712.13 260.69 710.05 266.49 394.77 266.78 379.05 266.79 378.59 267.8 323.51 269.27 243.67 269.27 243.66 270.27 189.54 270.8 189.54 271.82 248.17 273.15 324.48 274.1 378.63 274.1 379.03 274.14 381.26 274.14 381.27 275.98 486.82 276.17 497.31 279.97 715.46 280.01 717.56" fill="#3f3d56"/><rect x="462.57814" y="535.80109" width="35.40849" height="9.37282" transform="translate(-389.83614 231.83478) rotate(-27.76587)" fill="#3f3d56"/><rect x="176.6686" y="755.71631" width="89.3717" height="2" fill="#cbcbcb"/><rect x="340.66848" y="789.71631" width="89.37183" height="2" fill="#cbcbcb"/><rect x="595.66848" y="763.71631" width="89.37183" height="2" fill="#cbcbcb"/><path d="M837.565,736.48182V678.308S860.23593,719.55074,837.565,736.48182Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><path d="M838.96539,736.47159l-42.85408-39.34115S841.82469,708.32094,838.96539,736.47159Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><path d="M394.565,750.48182V692.308S417.23593,733.55074,394.565,750.48182Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><path d="M395.96539,750.47159l-42.85408-39.34115S398.82469,722.32094,395.96539,750.47159Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><path d="M548.565,792.48182v-72.34S576.75662,771.4278,548.565,792.48182Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><path d="M550.30642,792.4691,497.0168,743.54785S553.862,757.46338,550.30642,792.4691Z" transform="translate(-193.3452 -54.14185)" fill="#f1f1f1"/><polygon points="813.31 729.49 812.76 731.42 644.93 683.62 518.5 711.49 356.81 739.11 356.59 739.05 280.01 717.56 260.65 712.13 201.52 695.53 152.2 706.52 137.78 709.73 106.43 716.72 106 714.77 137.81 707.68 152.17 704.48 201.58 693.47 201.82 693.53 260.69 710.05 279.97 715.46 356.91 737.06 518.11 709.53 644.99 681.56 645.24 681.62 813.31 729.49" fill="#cbcbcb"/><path d="M706.39641,175.57875l12.79486-10.23341c-9.93975-1.09662-14.0238,4.32429-15.69525,8.615-7.76532-3.22446-16.21881,1.00136-16.21881,1.00136l25.6001,9.29375A19.37195,19.37195,0,0,0,706.39641,175.57875Z" transform="translate(-193.3452 -54.14185)" fill="#3f3d56"/><path d="M236.39641,171.57875l12.79486-10.23341c-9.93975-1.09662-14.0238,4.32429-15.69525,8.615-7.76532-3.22446-16.21881,1.00136-16.21881,1.00136l25.6001,9.29375A19.37195,19.37195,0,0,0,236.39641,171.57875Z" transform="translate(-193.3452 -54.14185)" fill="#3f3d56"/><path d="M678.39641,366.57875l12.79486-10.23341c-9.93975-1.09662-14.0238,4.32429-15.69525,8.615-7.76532-3.22446-16.21881,1.00136-16.21881,1.00136l25.6001,9.29375A19.37195,19.37195,0,0,0,678.39641,366.57875Z" transform="translate(-193.3452 -54.14185)" fill="#3f3d56"/><polygon points="398.156 752.578 407.935 756.211 426.602 720.221 412.169 714.859 398.156 752.578" fill="#ffb7b7"/><path d="M590.19264,802.59973l19.25843,7.15521.00077.00029a13.09339,13.09339,0,0,1,7.71251,16.833l-.14819.39882L585.4846,815.27175Z" transform="translate(-193.3452 -54.14185)" fill="#2f2e41"/><polygon points="494.392 762.733 504.824 762.732 509.787 722.494 494.39 722.495 494.392 762.733" fill="#ffb7b7"/><path d="M685.92675,813.46865l20.54469-.00083h.00083A13.09339,13.09339,0,0,1,719.565,826.5603v.42546l-33.63758.00125Z" transform="translate(-193.3452 -54.14185)" fill="#2f2e41"/><path d="M639.97532,537.80543l3.40369-6.80737,28.93133,14.46566-.85092,5.95645,5.531,7.23284s9.36014,5.10553,7.6583,22.124l-1.70185,16.16751-2.1273,20.84758,14.89113,51.48075,7.65829,68.07373L708.9,792.231l-26.804-1.27638-24.67672-89.34677-43.397,96.15414L584.24,790.10367l40.84424-95.30321,5.10553-39.99332s-3.40369-21.273,12.76382-35.7387l-2.55277-7.6583V601.973l-8.50921-45.02179Z" transform="translate(-193.3452 -54.14185)" fill="#2f2e41"/><rect x="647.55911" y="633.94132" width="0.99996" height="68.9611" transform="translate(-350.46045 146.88012) rotate(-15.75119)" opacity="0.2"/><rect x="640.82625" y="617.79206" width="41.69516" height="4.25461" transform="translate(1130.00244 1185.69687) rotate(-180)" fill="#3f3d56"/><ellipse cx="489.1762" cy="566.20297" rx="1.70184" ry="4.25461" fill="#3f3d56"/><circle cx="663.71854" cy="506.89834" r="22.68166" transform="translate(-292.76624 792.00009) rotate(-61.33678)" fill="#ffb7b7"/><circle cx="435.66495" cy="424.59364" r="20.06577" fill="#2f2e41"/><path d="M603.54633,476.58622a20.06688,20.06688,0,1,0,39.1429,8.22881,20.06709,20.06709,0,0,1-39.1429-8.22881Z" transform="translate(-193.3452 -54.14185)" fill="#2f2e41"/><path d="M682.81808,500.60116a23.72427,23.72427,0,1,1-14.15694-19.09959c3.9626-3.19569,8.8755-2.20524,12.86956,1.16744,4.51668,3.8135,5.85708,6.4332,9.36,12.70452C687.4463,495.85728,686.26261,500.11741,682.81808,500.60116Z" transform="translate(-193.3452 -54.14185)" fill="#2f2e41"/><path d="M599.44407,568.81214c.25385,6.72194.75692,19.95277.75692,20.62813,0,.71163,10.03071,21.48027,14.364,30.41866v.00454c.3083.63.58473,1.20113.82951,1.70428a4.02849,4.02849,0,0,0,3.70315,2.27537l18.93735-.34a4.03609,4.03609,0,0,0,3.96607-3.93434l2.11229-83.31478a2.05974,2.05974,0,0,0-2.05784-2.1122H617.63357a5.49075,5.49075,0,0,0-4.94055,3.10032l-11.72139,24.24972a15.49908,15.49908,0,0,0-1.52756,7.32025Z" transform="translate(-193.3452 -54.14185)" fill="var(--app-color)"/><path d="M642.33058,613.85155A54.23154,54.23154,0,0,0,655.27,602.91607a60.00782,60.00782,0,0,0,14.95545-34.88818c.96285-11.07248-1.2342-19.30275-6.53-24.46263-6.7316-6.55908-15.89441-5.60607-16.28116-5.562l-.41022.04647-6.20762,5.25262,1.75663,2.076,5.55449-4.7c1.70019-.085,8.64149-.10336,13.712,4.85622,4.66722,4.5652,6.58375,12.05382,5.69647,22.25783a57.308,57.308,0,0,1-14.20782,33.23691,52.656,52.656,0,0,1-12.2903,10.44038Z" transform="translate(-193.3452 -54.14185)" fill="var(--app-color)"/><rect x="623.09094" y="569.15092" width="0.90647" height="33.77971" transform="translate(-269.30664 1024.79144) rotate(-78.39377)" fill="#3f3d56"/><rect x="601.93088" y="560.01391" width="52.6946" height="0.90663" transform="translate(-150.69212 1111.22225) rotate(-87.66255)" fill="#3f3d56"/><path d="M599.44407,568.81214c.25385,6.72194.75692,19.95277.75692,20.62813,0,.71163,10.03071,21.48027,14.364,30.41866l-8.07711-46.8994a10.33774,10.33774,0,0,0-6.7129-7.97295A15.21407,15.21407,0,0,0,599.44407,568.81214Z" transform="translate(-193.3452 -54.14185)" fill="#3f3d56"/><path d="M649.0698,667.10044a7.97908,7.97908,0,0,1,2.5951-11.95656l-1.64153-18.1595,10.79217-3.68909,1.958,25.67729a8.02231,8.02231,0,0,1-13.70373,8.12786Z" transform="translate(-193.3452 -54.14185)" fill="#ffb7b7"/><path d="M642.00644,557.50044a12.45006,12.45006,0,0,1,8.42155-12.74222,11.30947,11.30947,0,0,1,7.11255.00623,12.44856,12.44856,0,0,1,8.43339,11.84851l.809,92.22236-19.1231.69345Z" transform="translate(-193.3452 -54.14185)" fill="#cbcbcb"/></svg></div>
                        <div class="details">
                            <span>Hmmm...</span>
                            <span>Henüz kimse bu gönderiyi beğenmemiş, ilk beğenen sen ol!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal-area>
</div>
</body>
</html>