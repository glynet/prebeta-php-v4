var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
String.prototype.uiRepair = function () {
    return this.toString().replace(/\\/g, "").split("{/quotes}").join("'");
};
String.prototype.replaceAll = function (search, replacement) {
    let target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};
Object.prototype.case = function (v) {
    if (this.hasOwnProperty(v)) {
        if (typeof this[v] === 'function') {
            return this[v]();
        }
        else {
            return this[v];
        }
    }
};
let user = {};
let lastPage = { name: "", data: {} };
let bottomAlertTimeout;
let activeModalClassList = '';
let activeDropdownClassList = '';
let activePostMenuClassList = false;
let searchSuggestionsSelectedItem = 0;
let settingsTab = 0;
const ui = {
    syncUsernameToAvailable: (string) => {
        const res = /^[a-zA-Z0-9_.]+$/.exec(string);
        return !!res;
    },
    addDots: (string, limit) => {
        let dots = "...";
        if (string.length > limit)
            string = string.substring(0, limit) + dots;
        return string;
    },
    reducedMotionMode: (open = true) => {
        let body = $('body');
        body.classList.remove('reduced-motion-mode');
        if (open)
            body.classList.add('reduced-motion-mode');
    },
    changeLineHeight: (value = 7) => {
        let default_value = 7;
        let default_line_height = 24;
        doc.cookies.set('rwRlh', `${value}`, 300);
        if ((value - default_value) < 0) {
            $('body').style.lineHeight = `${default_line_height - Math.abs(value - default_value)}px`;
        }
        else {
            $('body').style.lineHeight = `${default_line_height + Math.abs(value - default_value)}px`;
        }
    },
    changeFontSize: (value = 9) => {
        let default_value = 9;
        doc.cookies.set('rwRfs', value.toString(), 300);
        if ((value - default_value) < 0) {
            for (let i = 10; i < 40; i++) {
                document.documentElement.style.setProperty(`--font-size-${i}px`, `${i - Math.abs(value - default_value)}px`);
            }
        }
        else {
            for (let i = 10; i < 40; i++) {
                document.documentElement.style.setProperty(`--font-size-${i}px`, `${i + Math.abs(value - default_value)}px`);
            }
        }
    },
    color: {
        changeBrightness: (color, percent) => {
            let num = parseInt(color.replace("#", ""), 16), amt = Math.round(2.55 * percent), R = (num >> 16) + amt, B = (num >> 8 & 0x00FF) + amt, G = (num & 0x0000FF) + amt;
            return "#" + (0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 + (B < 255 ? B < 1 ? 0 : B : 255) * 0x100 + (G < 255 ? G < 1 ? 0 : G : 255)).toString(16).slice(1);
        },
        hexToRgba: (hex, alpha = 1) => {
            const [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
            return `rgba(${r},${g},${b},${alpha})`;
        }
    },
    desktop: {
        searchInput: {
            go: () => {
                $$('.search-result-other')[Math.abs(searchSuggestionsSelectedItem) - 1].click();
            },
            select: (count) => {
                $$('.search-result-other').forEach(item => item.classList.remove('search-result-selected'));
                $$('.search-result-other')[count - 1].classList.add('search-result-selected');
            },
            up: () => {
                if (0 > searchSuggestionsSelectedItem)
                    searchSuggestionsSelectedItem++;
                ui.desktop.searchInput.select(Math.abs(searchSuggestionsSelectedItem));
            },
            down: () => {
                let items = $$('.search-result-other');
                if (items.length > Math.abs(searchSuggestionsSelectedItem))
                    searchSuggestionsSelectedItem--;
                ui.desktop.searchInput.select(Math.abs(searchSuggestionsSelectedItem));
            }
        },
        dropdown: {
            toggle: (name) => {
                let dd = $(name);
                if (activeDropdownClassList == name) {
                    dd.classList.add('dropdown-hide');
                    activeDropdownClassList = '';
                    setTimeout(() => {
                        dd.classList.remove('dropdown-hide');
                        dd.style.display = 'none';
                    }, 300);
                }
                else {
                    dd.style.display = 'block';
                    setTimeout(() => activeDropdownClassList = name, 300);
                }
            },
            hide: (name) => {
                let dd = $(name);
                activeDropdownClassList = '';
                dd.classList.add('dropdown-hide');
                setTimeout(() => {
                    dd.classList.remove('dropdown-hide');
                    dd.style.display = 'none';
                }, 300);
            },
            type: {
                themes: () => {
                    ui.desktop.dropdown.toggle('.themes-dropdown');
                },
                notifications: () => {
                    client.notifications();
                    ui.desktop.dropdown.toggle('.notifications-dropdown');
                }
            }
        },
        trendingTopics: {
            more: () => {
                $('.trending-topics').setAttribute("show-more", "true");
            },
            less: () => {
                $('.trending-topics').setAttribute("show-more", "false");
            }
        },
        categories: {
            scroll: (left = false) => {
                let container = $('.uiKitDesktop-CategoriesThingSlider');
                let containerMaxWidth = (container.scrollWidth - container.clientWidth);
                let leftButton = $('.uiKitDesktop-CategoriesThingSlider-left-button-container');
                let rightButton = $('.uiKitDesktop-CategoriesThingSlider-right-button-container');
                if (left) {
                    leftButton.style.display = 'flex';
                    leftButton.style.opacity = '1';
                    container.scrollLeft += 500;
                    if (containerMaxWidth == container.scrollLeft) {
                        rightButton.style.opacity = '0';
                        setTimeout(() => rightButton.style.display = 'none', 100);
                    }
                }
                else {
                    rightButton.style.display = 'flex';
                    rightButton.style.opacity = '1';
                    if ((container.scrollLeft - 500) <= 350) {
                        container.scrollLeft = 0;
                    }
                    else {
                        container.scrollLeft = (container.scrollLeft - 500);
                    }
                    if ((container.scrollLeft - 500) < 0 || (container.scrollLeft - 500) == 0) {
                        leftButton.style.opacity = '0';
                        setTimeout(() => leftButton.style.display = 'none', 100);
                    }
                }
            },
            get: () => {
                let categories_area = $('.categories');
                _({
                    url: 'api/@me/explore/categories/collect',
                    method: 'GET'
                }, (r) => {
                    let categoriesData = JSON.parse(r['response']);
                    let rightButton = $('.categories-right-button-container');
                    categoriesData.forEach((category) => {
                        categories_area.innerHTML += `
                            <div class="category-container">
                                <div class="category-content">
                                    <div class="category-image">
                                        <div class="category-image-filter">
                                            <div class="category-name">
                                                <span>${category['details'].title}</span>
                                            </div>
                                        </div>
                                        <img src="${category['details'].thumbnail}" alt="">
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    if (!(categories_area.scrollWidth > categories_area.clientWidth)) {
                        categories_area.style.justifyContent = 'center';
                        rightButton.style.display = 'none';
                    }
                });
            }
        },
        left: {
            unselect: () => {
                $$('.menu-item')
                    .forEach(item => item.classList.remove('selected'));
            },
            select: (id, auto = true) => {
                let menuItem = $('.menu-' + id);
                ui.desktop.left.unselect();
                if (menuItem)
                    menuItem.classList.add('selected');
                if (auto)
                    app.open(id);
            }
        },
        right: {
            parseItems: () => {
                let append_data = $('right-panel');
                let dynamic_panel = $('.dynamic-right-panel');
                if (append_data && dynamic_panel) {
                    dynamic_panel.innerHTML = append_data.innerHTML.replaceAll('@create_click', '@click');
                    dynamic_panel.style.display = 'block';
                    append_data.innerHTML = '';
                    app.clickListener();
                }
            }
        },
        settings: {
            updateChanges: () => {
                let inputs = $$(`.settings-${settingsTab}`);
                inputs.forEach((item) => {
                    if (item.type == 'checkbox' || item.type == 'radio') {
                        item.setAttribute('data-default-value', String(item.checked));
                    }
                    else {
                        item.setAttribute('data-default-value', item.value);
                    }
                });
            },
            changesControl: (restore = false) => {
                let inputs = $$(`.settings-${settingsTab}`);
                let changed = 0;
                for (let i = 0; i < inputs.length; i++) {
                    let input = inputs[i];
                    let value = input.type == 'checkbox' || input.type == 'radio' ? input.checked.toString() : input.value;
                    if (value !== input.getAttribute('data-default-value')) {
                        if (restore) {
                            if (input.type == 'checkbox') {
                                input.checked = (input.getAttribute('data-default-value') == 'true');
                            }
                            else if (input.type == 'radio') {
                                input.checked = (input.getAttribute('data-default-value') == 'true');
                            }
                            else {
                                input.value = input.getAttribute('data-default-value');
                            }
                        }
                        else {
                            changed++;
                        }
                    }
                }
                if (changed == 0) {
                    return ui.desktop.settings.saveChanges(false);
                }
                else {
                    return ui.desktop.settings.saveChanges(true);
                }
            },
            saveChanges: (show = true) => {
                let container = $('.save-changes-container');
                let dynamic_content = $('.settings-dynamic');
                if (show) {
                    dynamic_content.style.paddingBottom = '90px';
                    container.style.display = 'flex';
                    setTimeout(() => container.style.opacity = '1', 100);
                }
                else {
                    dynamic_content.style.paddingBottom = 'var(--settings-content-padding)';
                    container.style.opacity = '0';
                    setTimeout(() => container.style.display = 'none', 100);
                }
            }
        }
    }
};
const doc = {
    cookies: {
        set: (name, value, days) => {
            let expires = "";
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        },
        get: (name) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2)
                return parts.pop().split(';').shift();
        }
    }
};
const $ = (name) => window.document.querySelector(name);
const $$ = (name) => window.document.querySelectorAll(name);
const $$$ = (name, callback) => $(name).onclick = callback;
const _file = ({ url, file }) => __awaiter(this, void 0, void 0, function* () {
    let formData = new FormData();
    formData.append("file", file);
    yield fetch(url, {
        method: "POST",
        body: formData
    }).then(r => r);
});
const _ = ({ url, method = "GET", data = {} }, callback = null) => {
    const request = new XMLHttpRequest();
    const urlParams = Object.keys(data)
        .map(k => encodeURIComponent(k) + "=" + encodeURIComponent(data[k]))
        .join("&");
    request.open(method, `${url}${urlParams.length > 3 ? `?ts=true&${urlParams}` : ""}`, true);
    request.onload = () => {
        let cbData = { ok: false, response: null };
        if (request.status === 200) {
            cbData = { ok: true, response: request.responseText };
            if (callback)
                callback(cbData);
        }
    };
    request.send();
};
function switchMatch(s) {
    return s;
}
var Glynet;
(function (Glynet) {
    class Application {
        changeUrl(title) {
            window.history.pushState(null, null, title);
        }
        newTitle(title) {
            window.document.title = title;
        }
        search(query) {
            _({
                url: 'api/@me/search/suggestions?q=' + query,
                method: 'GET'
            }, (r) => {
                const data = JSON.parse(r['response']);
                let container = $('.search-items');
                container.innerHTML = "";
                data.forEach((item) => {
                    let icon;
                    let click;
                    switch (item['type']) {
                        case 'location':
                            click = ``;
                            icon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="pin"><rect width="24" height="24" opacity="0"/><circle cx="12" cy="9.5" r="1.5"/><path d="M12 2a8 8 0 0 0-8 7.92c0 5.48 7.05 11.58 7.35 11.84a1 1 0 0 0 1.3 0C13 21.5 20 15.4 20 9.92A8 8 0 0 0 12 2zm0 11a3.5 3.5 0 1 1 3.5-3.5A3.5 3.5 0 0 1 12 13z"/></g></g></svg>`;
                            break;
                        case 'hashtag':
                            click = ``;
                            icon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="hash"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M20 14h-4.3l.73-4H20a1 1 0 0 0 0-2h-3.21l.69-3.81A1 1 0 0 0 16.64 3a1 1 0 0 0-1.22.82L14.67 8h-3.88l.69-3.81A1 1 0 0 0 10.64 3a1 1 0 0 0-1.22.82L8.67 8H4a1 1 0 0 0 0 2h4.3l-.73 4H4a1 1 0 0 0 0 2h3.21l-.69 3.81A1 1 0 0 0 7.36 21a1 1 0 0 0 1.22-.82L9.33 16h3.88l-.69 3.81a1 1 0 0 0 .84 1.19 1 1 0 0 0 1.22-.82l.75-4.18H20a1 1 0 0 0 0-2zM9.7 14l.73-4h3.87l-.73 4z"/></g></g></svg>`;
                            break;
                        case 'user':
                            click = `app.open('profile', { username: '${item['details'].username}' })`;
                            icon = `<img src="${item['details'].avatar}" alt="${item['details'].username} adlı kullanıcının profil resmi">`;
                            break;
                        default:
                            click = ``;
                            icon = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"/><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"/></g></g></svg>`;
                            break;
                    }
                    let content = `
                        <div @click="${click}" class="search-result-other _ResultSjehX-${Math.floor(Math.random() * 100000)}">
                            <div class="icon" ${item['type'] == 'user' ? '' : 'data-svg'}>${icon}</div>
                            <div class="text">
                                <span>${item['details'].title}</span>
                                ${item['type'] == 'user' ? `<span>@${item['details'].username}</span>` : ''}
                            </div>
                        </div>
                    `;
                    container.innerHTML += content;
                });
                app.clickListener();
            });
        }
        clickListener() {
            $$("div, span, img, button, label").forEach((elem) => {
                let click = elem.getAttribute("@click");
                if ((click === null || click === void 0 ? void 0 : click.length) > 0 || click !== null) {
                    const classname = `.${[].slice.apply(elem.classList).join('.')}`;
                    $$$(classname, () => eval(click));
                    $(classname).removeAttribute("@click");
                }
            });
            $$("input, textarea").forEach((elem) => {
                const classname = `.${[].slice.apply(elem.classList).join('.')}`;
                let max_length = elem.getAttribute("@max_length");
                if ((max_length === null || max_length === void 0 ? void 0 : max_length.length) > 0 || max_length !== null) {
                    $(classname).removeAttribute("@max_length");
                    $(classname).addEventListener('keyup', function () {
                        if (elem.value.length >= Number(max_length)) {
                            elem.value = elem.value.slice(0, Number(max_length));
                        }
                    });
                }
            });
        }
        copyClipboard(text, alertType) {
            let alert = '';
            switch (alertType) {
                case 0:
                    alert = 'Sayfa bağlantısı panoya kopyalandı!';
                    break;
                case 1:
                    alert = 'Gönderi bağlantısı panoya kopyalandı';
                    break;
                case 3:
                    alert = 'Bağlantı panoya kopyalandı!';
                    break;
            }
            let inp = $('.clipboard label input');
            inp.value = text;
            inp.focus();
            inp.select();
            document.execCommand('copy');
            this.bottomAlert(alert);
        }
        settings(category = 1, tab = 1, group = 1, title) {
            let title_area = $('.title-bar');
            let title_groups = $$('.title-bar label');
            let title_length = title_groups.length;
            let menu_items = $$('.settings-menu .menu-group .group-item');
            let contents = $$('.settings-details-container');
            let settings = $('.settings-content');
            let settings_dynamic = $('.settings-dynamic');
            settingsTab = category;
            function newTitleGroup(title) {
                let node = document.createElement("label");
                node.innerHTML = `
                    <div @click="app.settings(${category}, ${tab}, ${group});" data-c="${category}" data-t="${tab}" class="title-group title-tab-${tab} title-group-${group} title-group-id-${Math.floor(Math.random() * 9999)}">
                        <div class="text">
                            <span>${title}</span>
                        </div>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="chevron-right"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/><path d="M10.5 17a1 1 0 0 1-.71-.29 1 1 0 0 1 0-1.42L13.1 12 9.92 8.69a1 1 0 0 1 0-1.41 1 1 0 0 1 1.42 0l3.86 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-.7.32z"/></g></g></svg>
                        </div>
                    </div>
                `;
                title_area.appendChild(node);
            }
            menu_items.forEach(m => m.removeAttribute('selected'));
            menu_items[(category - 1)].setAttribute('selected', 'true');
            contents.forEach(c => c.style.display = 'none');
            contents.forEach(c => {
                if (c.getAttribute('data-category') == category.toString() && c.getAttribute('data-tab') == tab.toString() && c.getAttribute('data-group') == group.toString())
                    c.style.display = 'block';
            });
            if (title_area.innerText.length == 0)
                _({
                    url: 'pages/settings',
                    method: 'GET'
                }, (r) => {
                    settings_dynamic.innerHTML = r['response'];
                    let range_font_size = $('.range-slider-font-size');
                    let range_line_height = $('.range-slider-line-height');
                    let username_input = $('.settings-key-2-username.settings-inputs');
                    let name_input = $('.settings-key-2-name.settings-inputs');
                    let reduced_motion_mode_slider = $('.settings-reduced-motion-mode-slider');
                    let ding_dong_slider = $('.settings-ding-dong-notifications-slider');
                    let browser_notifications_slider = $('.settings-browser-notifications-slider');
                    let profile_avatar_input = $('.profile-avatar-change-input');
                    let profile_banner_input = $('.profile-banner-change-input');
                    let inputs = $$('.settings-inputs');
                    profile.getBlockedUsers();
                    inputs.forEach((i) => {
                        i.addEventListener(i.type == 'checkbox' ? 'change' : i.type == 'radio' ? 'click' : 'keyup', () => {
                            ui.desktop.settings.changesControl();
                        });
                    });
                    profile_banner_input.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            let previews = {
                                color: $('.change-banner-container .banner .banner-content'),
                                image: $('.change-banner-container .banner img'),
                                video: $('.change-banner-container .banner video'),
                                miniProfile: {
                                    color: $('.edit-profile-mini-profile-banner-area .banner-content'),
                                    image: $('.edit-profile-mini-profile-banner-area img'),
                                    video: $('.edit-profile-mini-profile-banner-area video'),
                                }
                            };
                            if (file.size < 33554432) {
                                let reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.addEventListener("load", function (e) {
                                    let file_type = file.type.split('/');
                                    let accept_types = ['jpg', 'png', 'jpeg', 'mp4'];
                                    if (accept_types.includes(file_type[1])) {
                                        let result = e.target.result.toString();
                                        previews.color.style.display = "none";
                                        previews.image.style.display = "none";
                                        previews.video.style.display = "none";
                                        previews.miniProfile.color.style.display = "none";
                                        previews.miniProfile.image.style.display = "none";
                                        previews.miniProfile.video.style.display = "none";
                                        if (file_type[0] == 'image') {
                                            previews.image.style.display = "block";
                                            previews.miniProfile.image.style.display = "block";
                                            previews.image.src = result;
                                            previews.miniProfile.image.src = result;
                                        }
                                        else if (file_type[0] == 'video') {
                                            previews.video.style.display = "block";
                                            previews.miniProfile.video.style.display = "block";
                                            previews.video.src = result;
                                            previews.miniProfile.video.src = result;
                                        }
                                        if (lastPage['name'] == 'profile' && lastPage['data'].username == user['username']) {
                                            let banner = {
                                                color: $('.banner-content-color'),
                                                image: $('.banner-content-image'),
                                                video: $('.banner-content-video'),
                                                videoSrc: $('.banner-content-video video'),
                                                modal: {
                                                    image: $('.banner-content-modal-image'),
                                                    video: $('.banner-content-modal-video'),
                                                    imageSrc: $('.banner-content-modal img'),
                                                    videoSrc: $('.banner-content-modal video')
                                                }
                                            };
                                            banner.color.style.display = "none";
                                            banner.image.style.display = "none";
                                            banner.video.style.display = "none";
                                            banner.modal.image.style.display = "none";
                                            banner.modal.video.style.display = "none";
                                            if (file_type[0] == 'image') {
                                                banner.image.style.display = "block";
                                                banner.modal.image.style.display = "block";
                                                banner.image.style.backgroundImage = `url(${result})`;
                                                banner.modal.imageSrc.src = result;
                                            }
                                            else {
                                                banner.video.style.display = "block";
                                                banner.modal.video.style.display = "block";
                                                banner.videoSrc.src = result;
                                                banner.modal.videoSrc.src = result;
                                            }
                                        }
                                    }
                                    profile_banner_input.value = null;
                                    _file({
                                        url: 'api/@me/client/contents/update/banner',
                                        file: file
                                    }).then(r => r);
                                });
                            }
                        }
                    });
                    profile_avatar_input.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            let file = this.files[0];
                            let preview = $('.change-avatar-container .avatar-preview img');
                            if (file.size < 8388608) {
                                let reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.addEventListener("load", function (e) {
                                    let result = e.target.result.toString();
                                    let profileModal = $('#profile-avatar > div > div > div');
                                    preview.src = result;
                                    if (profileModal)
                                        profileModal.style.backgroundImage = `url(${result})`;
                                    $$('.pp-content img')
                                        .forEach((img) => img.src = result);
                                    profile_avatar_input.value = null;
                                    _file({
                                        url: 'api/@me/client/contents/update/avatar',
                                        file: file
                                    }).then(r => r);
                                });
                            }
                        }
                    });
                    ding_dong_slider.checked = (doc.cookies.get('rwDdn') == "true");
                    ding_dong_slider.addEventListener('click', function () {
                        doc.cookies.set('rwDdn', this.checked.toString(), 300);
                    });
                    browser_notifications_slider.checked = (doc.cookies.get('rwBrn') == "true");
                    browser_notifications_slider.addEventListener('click', function () {
                        doc.cookies.set('rwBrn', this.checked.toString(), 300);
                    });
                    reduced_motion_mode_slider.checked = (doc.cookies.get('rwRm') == "true");
                    reduced_motion_mode_slider.addEventListener('click', function () {
                        ui.reducedMotionMode(this.checked);
                        doc.cookies.set('rwRm', this.checked.toString(), 300);
                    });
                    range_line_height.value = doc.cookies.get('rwRlh');
                    range_line_height.addEventListener('mouseup', () => {
                        ui.changeLineHeight(parseInt(range_line_height.value));
                    });
                    range_font_size.value = doc.cookies.get('rwRfs');
                    range_font_size.addEventListener('mouseup', function () {
                        ui.changeFontSize(parseInt(range_font_size.value));
                    });
                    name_input.addEventListener('keyup', function () {
                        let autoChangeElem = $('.settings-edit-profile-top-details-user-name span');
                        autoChangeElem.innerText = name_input.value;
                    });
                    username_input.addEventListener('keyup', function () {
                        let autoChangeElem = $('.settings-edit-profile-top-details-user-username span');
                        if (this.value.length !== 0 && this.value !== '') {
                            let newValue = this.value.split('').filter(ui.syncUsernameToAvailable).join('').toString();
                            this.value = newValue;
                            autoChangeElem.innerText = newValue;
                        }
                    });
                });
            if (!title)
                title = menu_items[(category - 1)].innerText;
            if (tab == 1) {
                title_area.innerHTML = '';
                title_length++;
                newTitleGroup(title);
            }
            if (title_length !== group) {
                for (let i = (group + 1); i < title_length; i++) {
                    if (title_groups[i])
                        title_groups[i].remove();
                }
            }
            else {
                newTitleGroup(title);
            }
            settings.scrollTop = 0;
            app.modal('settings', true);
            app.clickListener();
        }
        open(name, data = {}) {
            const body = $('body .app .center main#content');
            ui.desktop.left.select(name, false);
            if (name == lastPage['name']) {
                if (JSON.stringify(data) == JSON.stringify(lastPage['data']))
                    return;
            }
            else if (name == 'myprofile') {
                name = 'profile';
                data = { username: user['username'], user_id: parseInt(user['id']) };
            }
            if (name == 'profile' && data['user_id'] == parseInt(user['id']))
                ui.desktop.left.select('myprofile', false);
            lastPage = { name, data };
            $$('.removable-box').forEach(e => {
                app.anim(e, { opacity: 0 }, 300);
                setTimeout(() => {
                    e.remove();
                    $('.dynamic-right-panel').style.display = 'none';
                }, 300);
            });
            app.anim(body, { padding: '20px', opacity: '0' }, 300);
            _({ url: 'pages/' + name, method: 'GET', data }, (r) => {
                setTimeout(() => {
                    app.anim(body, { padding: '0px', opacity: '1' }, 300);
                    app.changeUrl((name == 'profile' ? `@${data['username']}` : name));
                    body.innerHTML = r['response'];
                    app.clickListener();
                    switch (name) {
                        case 'profile':
                            posts.collect('profile', $('.profile-container').id.replace('c', ''));
                            break;
                        case 'explore':
                            posts.collect('explore');
                            ui.desktop.categories.get();
                            break;
                        case 'bookmarks':
                            posts.collect('bookmarks');
                            break;
                        case 'feed':
                        default:
                            posts.collect('feed');
                            stories.getStories();
                            break;
                    }
                    app.scrollToTop('.right');
                    app.newTitle(`${$('new-details g-new-title').innerText} | Glynet`);
                    ui.desktop.right.parseItems();
                }, 300);
            });
        }
        openExternal(url, accept = false) {
            if (accept) {
                window.open(`mommycanigoout/?r=${btoa(url)}`, '_blank');
            }
            else {
                this.confirm('Yönlendirme', 'Gitmek üzere olduğunuz internet sitesinin Glynet ile uzaktan veya yakından bağlantısı bulunmamaktadır. Oluşabilecek herhangi bir güvenlik ihmaline karşın dikkatli olmanızı öneririz.', ['Anladım', 'Geri dön'], `app.openExternal('${url}'}', true)`);
            }
        }
        router(url) {
            url = decodeURIComponent(url);
            if (url.split("").includes("/")) {
                const key = url.split("/")[0];
                const data = url.split("/")[1];
                switch (key) {
                    case "profile":
                        this.open('profile', { username: data });
                        break;
                }
            }
            else if (url.split("").includes("@")) {
                this.open('profile', { username: url.split("@")[1] });
            }
            else {
                this.open((url.replace(/\s/g, "") == "" ? "feed" : url));
            }
        }
        anim(elem, style, duration = 50) {
            let oldTransitionDuration = elem.style.transitionDuration;
            elem.style.transitionDuration = `${duration}ms`;
            setTimeout(() => {
                Object.entries(style).forEach(e => {
                    elem.style[e[0]] = e[1];
                });
                setTimeout(() => elem.style.transitionDuration = oldTransitionDuration, duration);
            }, 100);
        }
        scrollToTop(element = ".app", duration = 300) {
            let scrollElement = $(element);
            if (scrollElement.scrollTop === 0)
                return;
            const cosParameter = scrollElement.scrollTop / 2;
            let scrollCount = 0, oldTimestamp = null;
            function step(newTimestamp) {
                if (oldTimestamp !== null) {
                    scrollCount += Math.PI * (newTimestamp - oldTimestamp) / duration;
                    if (scrollCount >= Math.PI)
                        return scrollElement.scrollTop = 0;
                    scrollElement.scrollTop = cosParameter + cosParameter * Math.cos(scrollCount);
                }
                oldTimestamp = newTimestamp;
                window.requestAnimationFrame(step);
            }
            window.requestAnimationFrame(step);
        }
        bottomAlert(text) {
            let alertBox = $('.bottom-alert');
            let alertContent = $('.b-alert-content span');
            alertContent.innerText = text;
            alertBox.style.bottom = "30px";
            alertBox.style.opacity = "1";
            alertBox.style.transformStyle = "scale(1)";
            clearTimeout(bottomAlertTimeout);
            bottomAlertTimeout = setTimeout(() => {
                alertBox.style.bottom = "-70px";
                alertBox.style.opacity = "0";
                alertBox.style.transformStyle = "scale(0.50)";
            }, 5000);
        }
        confirm(title, desc, buttons, callback) {
            let modalArea = $('modal-area');
            let confirmId = Math.floor(Math.random() * 9800) + 1;
            let newModal = `
                <div class="modal" id="modal-${confirmId}">
                    <div class="modal-content">
                        <div class="template-1">
                            <div class="title">${title}</div>
                            <div class="content">${desc}</div>
            `;
            if (buttons)
                newModal += `
                            <div class="button-container">
                                <div @click="app.modal('modal-${confirmId}', false); ${callback !== undefined ? callback : ''}" class="button mdlBtnId-4${confirmId}">${buttons[0]}</div>
                                <div @click="app.modal('modal-${confirmId}', false);" class="button mdlBtnId-3${confirmId}">${buttons[1]}</div>
                            </div>
                `;
            newModal += `
                        </div>
                    </div>
                </div>
            `;
            modalArea.innerHTML += newModal;
            app.clickListener();
            this.modal('modal-' + confirmId, true);
        }
        follow(id, type) {
            switch (type) {
                case 1:
                    let button = $(`.profile-btn-flw-${id}`);
                    let count = $(`#box-profile-metrics > div > div.metric-data-followers-${id}.metric-data > div.value`);
                    if (button.classList.contains('follow-btn')) {
                        this.bottomAlert('Takipten çıkıldı');
                        button.classList.remove('follow-btn');
                        count.innerHTML = (parseInt(count.innerHTML) - 1).toString();
                    }
                    else {
                        this.bottomAlert('Takip edildi');
                        button.classList.add('follow-btn');
                        count.innerHTML = (parseInt(count.innerHTML) + 1).toString();
                    }
                    break;
            }
            _({
                url: `api/@me/profile/follow/${id}`,
                method: 'POST'
            });
        }
        modal(id, open) {
            if (open) {
                $$('.modal').forEach(m => m.style.display = 'none');
                let m = $(`#${id}`);
                let m_content = $(`#${id} .modal-content`);
                activeModalClassList = id;
                m_content.style.display = 'block';
                m.style.display = 'flex';
            }
            else {
                let m = $(`#${id}`);
                let m_content = $(`#${id} .modal-content`);
                m_content.classList.add('modal-hide');
                setTimeout(() => {
                    m.style.display = 'none';
                    m_content.style.display = 'none';
                    m_content.classList.remove('modal-hide');
                }, 200);
            }
        }
    }
    Glynet.Application = Application;
})(Glynet || (Glynet = {}));
var Glynet;
(function (Glynet) {
    class Client {
        startSession() {
            _({
                url: 'api/@me/client',
                method: 'GET'
            }, (r) => {
                user = JSON.parse(r['response']);
                $$('.pp-content img')
                    .forEach((img) => img.src = user['avatar']);
                this.setColor(user['color']);
                this.setTheme(user['theme'], false);
            });
            this.getRank();
            ui.reducedMotionMode((doc.cookies.get('rwRm') == "true"));
            app.router(window.location.pathname.replace("/glynet.com/", ""));
        }
        getRank() {
            _({
                url: 'api/@me/client/level',
                method: 'GET'
            }, (r) => {
                let road = $('#box-fixed-header > div > div.rank > div > div.road > div');
                let title = $('#box-fixed-header > div > div.rank > div > div.text > span:nth-child(2)');
                let data = JSON.parse(r['response']);
                road.style.width = `${data['percent']}%`;
                title.innerHTML = `${data['level']} / ${data['level'] + 1}`;
            });
        }
        setColor(code) {
            doc.cookies.set('user_color', code, 300);
            document.documentElement.style.setProperty('--app-color', code);
            document.documentElement.style.setProperty('--app-color-x1', ui.color.changeBrightness(code, -10));
            document.documentElement.style.setProperty('--app-color-s1', ui.color.changeBrightness(code, 50));
            document.documentElement.style.setProperty('--app-color-trans', ui.color.hexToRgba(code, .5));
        }
        setTheme(type = 3, update = true) {
            let htmlElement = $('html');
            if (type > 0 && type < 5) {
                if (update && (parseInt(doc.cookies.get('theme')) !== type)) {
                    _({
                        url: `api/@me/client/theme/update/${type}`,
                        method: 'POST'
                    });
                    doc.cookies.set('theme', type.toString(), 300);
                }
                if (type == 2 || (type == 3 && (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches))) {
                    htmlElement.classList.value = 'theme-dark';
                }
                else if (type == 4) {
                    htmlElement.classList.value = 'theme-purple';
                }
                else {
                    htmlElement.classList.value = 'theme-light';
                }
                $$('.theme-section-dropdown-button').forEach(item => item.removeAttribute('selected'));
                if ($$('.theme-section-dropdown-button')[type - 1]) {
                    let selectElement = (type - 1);
                    if (parseInt(doc.cookies.get('theme')) == 3)
                        selectElement = 2;
                    $$('.theme-section-dropdown-button')[selectElement].setAttribute('selected', '');
                }
            }
        }
        updateColor(code) {
            let selected_color = $('.settings-color-box-selected');
            selected_color.style.setProperty('--box-color', '#' + code);
            this.setColor('#' + code);
            _({
                url: 'api/@me/client/color/update',
                data: { code }
            }, (r) => {
                console.log(code, r);
            });
        }
        updateContents(type, remove = false) {
            let inputs = {
                avatar: $('.profile-avatar-change-input'),
                banner: $('.profile-banner-change-input')
            };
            let previews = {
                avatar: $('.change-avatar-container .avatar-preview img'),
                banners: {
                    color: $('.change-banner-container .banner .banner-content'),
                    image: $('.change-banner-container .banner img'),
                    video: $('.change-banner-container .banner video')
                },
                miniProfile: {
                    color: $('.edit-profile-mini-profile-banner-area .banner-content'),
                    image: $('.edit-profile-mini-profile-banner-area img'),
                    video: $('.edit-profile-mini-profile-banner-area video'),
                }
            };
            if (!remove) {
                if (type == 1) {
                    inputs.avatar.click();
                }
                else {
                    inputs.banner.click();
                }
            }
            else {
                if (type == 1) {
                    let profileModal = $('#profile-avatar > div > div > div');
                    previews.avatar.src = 'img/avatar.png';
                    if (profileModal)
                        profileModal.style.backgroundImage = `url(img/avatar.png)`;
                    $$('.pp-content img')
                        .forEach((img) => img.src = 'img/avatar.png');
                }
                else {
                    previews.banners.color.style.display = "block";
                    previews.banners.image.style.display = "none";
                    previews.banners.video.style.display = "none";
                    previews.miniProfile.color.style.display = "block";
                    previews.miniProfile.image.style.display = "none";
                    previews.miniProfile.video.style.display = "none";
                    if (lastPage['name'] == 'profile' && lastPage['data'].username == user['username']) {
                        let banner = {
                            color: $('.banner-content-color'),
                            image: $('.banner-content-image'),
                            video: $('.banner-content-video')
                        };
                        banner.color.style.display = "block";
                        banner.image.style.display = "none";
                        banner.video.style.display = "none";
                    }
                }
                _({
                    url: `api/@me/client/contents/remove/${type}`
                });
            }
        }
        updateSettings(type) {
            const inputs = $$(`.settings-${type}`);
            let rObj = [];
            inputs.forEach((input) => {
                rObj.push({
                    name: input.type == 'radio' ? input.id.replace(`settings-radio-${type}-`, '') : input.classList[0].replace(`settings-key-${type}-`, ''),
                    value: input.type == 'checkbox' || input.type == 'radio' ? input.checked : input.value
                });
            });
            let urlType = window.btoa(unescape(encodeURIComponent(`settings-${type}`)));
            let urlQuery = window.btoa(unescape(encodeURIComponent(JSON.stringify(rObj))));
            _({
                url: `api/@me/client/settings/update/${urlType}/${urlQuery}`.replaceAll('=', 'd3eve'),
                method: 'POST'
            }, (r) => {
                console.log(JSON.parse(r['response']));
            });
            ui.desktop.settings.updateChanges();
            ui.desktop.settings.saveChanges(false);
        }
        updatePassword() {
            let oldPassword = $('.settings-change-password-input-old-password');
            let newPassword = $('.settings-change-password-input-new-password');
            let againPassword = $('.settings-change-password-input-again-password');
            _({
                url: 'api/@me/client/settings/password',
                method: 'POST',
                data: {
                    currentPassword: oldPassword.value,
                    newPassword: newPassword.value,
                    againPassword: againPassword.value
                }
            }, (r) => {
                let data = JSON.parse(r['response']);
                switch (data.message) {
                    case 3441:
                        app.bottomAlert('Şifreler birbirleriyle uyuşmuyor veya 8 karakterden kısa');
                        break;
                    case 3442:
                        app.bottomAlert('Girdiğiniz şifre geçerli değil');
                        break;
                }
                if (data.status) {
                    oldPassword.value = '';
                    newPassword.value = '';
                    againPassword.value = '';
                    app.settings(1);
                    user['token'] = data.token;
                    app.bottomAlert('Şifre başarıyla değiştirildi');
                }
            });
        }
        updateAccountPreferences(type) {
            let inputs = [
                {
                    value: $('.settings-update-account-email-input'),
                    preview: {
                        text: $('.settings-update-account-email-preview-input'),
                        container: $('.account-settings-top-email')
                    },
                    password: $('.settings-update-account-email-password-input')
                },
                {
                    value: $('.settings-update-account-phone-input'),
                    preview: {
                        text: $('.settings-update-account-phone-preview-input'),
                        container: $('.account-settings-top-phone-number')
                    },
                    password: $('.settings-update-account-phone-password-input')
                }
            ];
            if (inputs[type].password.value.length !== 0) {
                _({
                    url: `api/@me/client/account/update/${type}`,
                    data: {
                        value: btoa(inputs[type].value.value),
                        password: btoa(inputs[type].password.value)
                    }
                }, (r) => {
                    let data = JSON.parse(r['response']);
                    if (data.status) {
                        if (inputs[type].value.value.length == 0) {
                            inputs[type].preview.container.style.display = "none";
                        }
                        else {
                            inputs[type].preview.container.style.display = "block";
                        }
                        app.settings(1);
                        inputs[type].preview.text.innerText = inputs[type].value.value;
                        inputs[type].value.value = "";
                        inputs[type].password.value = "";
                    }
                    switch (data.message) {
                        case 6900:
                            app.bottomAlert('E-posta boş bırakılamaz');
                            break;
                        case 6910:
                            app.bottomAlert('Girilen değer çok az, minimum 8 karakter girilmelidir');
                            break;
                        case 7100:
                            app.bottomAlert('E-posta başarıyla güncellendi');
                            break;
                        case 7110:
                            app.bottomAlert('Girilen e-posta standart dışı');
                            break;
                        case 8100:
                            app.bottomAlert('Telefon numaranız başarıyla güncellendi');
                            break;
                        case 9100:
                            app.bottomAlert('Şifre başarıyla güncellendi');
                            break;
                        case 10000:
                            app.bottomAlert('Girilen şifre hatalı');
                            break;
                    }
                });
            }
        }
        notifications() {
            _({
                url: 'api/@me/notifications',
                method: 'GET'
            }, (r) => {
                let response = JSON.parse(r['response']);
                let followRequests = $('.notifications-content div.content div.follow-requests');
                let listArea = $('.notifications-content div.content div.list');
                let emptyMessage = $('.notifications-content div.empty');
                if (response.notifications.length !== 0) {
                    emptyMessage.style.display = 'none';
                    listArea.innerHTML = '';
                    response.notifications.forEach((item) => {
                        var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l, _m, _o, _p, _q, _r, _s, _t, _u, _v, _w, _x, _y, _z, _0, _1, _2, _3, _4, _5, _6, _7, _8, _9, _10;
                        let text;
                        let embed;
                        function createNotificationEmbed(obj) {
                            var _a;
                            let member_content;
                            let post_content;
                            if ((obj.banner !== undefined ? (obj.banner.url !== undefined) : false))
                                post_content = `
                                    <div class="post-content">
                                        ${(obj === null || obj === void 0 ? void 0 : obj.banner.url) == '' ?
                                    '' :
                                    (obj === null || obj === void 0 ? void 0 : obj.banner.type) == 'image' ?
                                        `<img src="${obj === null || obj === void 0 ? void 0 : obj.banner.url}" alt="">` :
                                        `<video src="${obj === null || obj === void 0 ? void 0 : obj.banner.url}" autoplay loop muted></video>`}
                                    </div>
                                `;
                            if ((obj.member !== undefined ? (obj.member.username !== undefined) : false))
                                member_content = `
                                    <div class="post-author">
                                        <div class="arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="corner-down-right"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/><path d="M19.78 12.38l-4-5a1 1 0 0 0-1.56 1.24l2.7 3.38H8a1 1 0 0 1-1-1V6a1 1 0 0 0-2 0v5a3 3 0 0 0 3 3h8.92l-2.7 3.38a1 1 0 0 0 .16 1.4A1 1 0 0 0 15 19a1 1 0 0 0 .78-.38l4-5a1 1 0 0 0 0-1.24z"/></g></g></svg>
                                        </div>
                                        <div class="author">
                                            <span>${obj === null || obj === void 0 ? void 0 : obj.member.username}</span>
                                            <span>${ui.addDots(obj === null || obj === void 0 ? void 0 : obj.member.text, 16)}</span>
                                        </div>
                                    </div>
                                `;
                            return `
                                <div class="embed-container">
                                    <div class="post">
                                        ${post_content !== undefined ? post_content : ''}
                                        <div class="post-text">
                                            ${(obj === null || obj === void 0 ? void 0 : obj.author.text) == '' && (obj.member !== undefined && ((_a = obj === null || obj === void 0 ? void 0 : obj.member) === null || _a === void 0 ? void 0 : _a.username) !== '') ?
                                '' :
                                `
                                            <div class="post-author">
                                                <div class="author">
                                                    <span>${obj === null || obj === void 0 ? void 0 : obj.author.username}</span>
                                                    <span>${ui.addDots(obj === null || obj === void 0 ? void 0 : obj.author.text, 16)}</span>
                                                </div>
                                            </div>
                                                    `}
                                            ${member_content !== undefined ? member_content : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                        switch (item['details']['type']) {
                            case 'like':
                                text = switchMatch({
                                    post: 'Gönderinizi beğendi',
                                    comment: 'Yorumunuzu beğendi',
                                    reply: 'Yanıtınızı beğendi'
                                }).case(item['details']['extend']['type']);
                                embed = createNotificationEmbed({
                                    banner: {
                                        url: (_d = (_c = (_b = (_a = item === null || item === void 0 ? void 0 : item.details) === null || _a === void 0 ? void 0 : _a.extend) === null || _b === void 0 ? void 0 : _b.details) === null || _c === void 0 ? void 0 : _c.content) === null || _d === void 0 ? void 0 : _d.url,
                                        type: (_h = (_g = (_f = (_e = item === null || item === void 0 ? void 0 : item.details) === null || _e === void 0 ? void 0 : _e.extend) === null || _f === void 0 ? void 0 : _f.details) === null || _g === void 0 ? void 0 : _g.content) === null || _h === void 0 ? void 0 : _h.type,
                                    },
                                    author: {
                                        username: user['username'],
                                        text: (_l = (_k = (_j = item === null || item === void 0 ? void 0 : item.details) === null || _j === void 0 ? void 0 : _j.extend) === null || _k === void 0 ? void 0 : _k.details) === null || _l === void 0 ? void 0 : _l.text
                                    }
                                });
                                break;
                            case 'mention':
                                text = switchMatch({
                                    post: 'Paylaştığı gönderide senden bahsetti',
                                    comment: 'Yorumunda senden bahsetti',
                                    reply: 'Yanıtında senden bahsetti'
                                }).case(item['details']['extend']['type']);
                                embed = createNotificationEmbed({
                                    banner: {
                                        url: (_q = (_p = (_o = (_m = item === null || item === void 0 ? void 0 : item.details) === null || _m === void 0 ? void 0 : _m.extend) === null || _o === void 0 ? void 0 : _o.details) === null || _p === void 0 ? void 0 : _p.content) === null || _q === void 0 ? void 0 : _q.url,
                                        type: (_u = (_t = (_s = (_r = item === null || item === void 0 ? void 0 : item.details) === null || _r === void 0 ? void 0 : _r.extend) === null || _s === void 0 ? void 0 : _s.details) === null || _t === void 0 ? void 0 : _t.content) === null || _u === void 0 ? void 0 : _u.type,
                                    },
                                    author: {
                                        username: (_v = item === null || item === void 0 ? void 0 : item.from) === null || _v === void 0 ? void 0 : _v.username,
                                        text: (_y = (_x = (_w = item === null || item === void 0 ? void 0 : item.details) === null || _w === void 0 ? void 0 : _w.extend) === null || _x === void 0 ? void 0 : _x.details) === null || _y === void 0 ? void 0 : _y.text
                                    }
                                });
                                break;
                            case 'quote':
                                text = 'Gönderinizi alıntıladı';
                                break;
                            case 'new-post':
                                text = 'Yeni bir gönderi paylaştı';
                                embed = createNotificationEmbed({
                                    banner: {
                                        url: (_2 = (_1 = (_0 = (_z = item === null || item === void 0 ? void 0 : item.details) === null || _z === void 0 ? void 0 : _z.extend) === null || _0 === void 0 ? void 0 : _0.details) === null || _1 === void 0 ? void 0 : _1.content) === null || _2 === void 0 ? void 0 : _2.url,
                                        type: (_6 = (_5 = (_4 = (_3 = item === null || item === void 0 ? void 0 : item.details) === null || _3 === void 0 ? void 0 : _3.extend) === null || _4 === void 0 ? void 0 : _4.details) === null || _5 === void 0 ? void 0 : _5.content) === null || _6 === void 0 ? void 0 : _6.type,
                                    },
                                    author: {
                                        username: (_7 = item === null || item === void 0 ? void 0 : item.from) === null || _7 === void 0 ? void 0 : _7.username,
                                        text: (_10 = (_9 = (_8 = item === null || item === void 0 ? void 0 : item.details) === null || _8 === void 0 ? void 0 : _8.extend) === null || _9 === void 0 ? void 0 : _9.details) === null || _10 === void 0 ? void 0 : _10.text
                                    }
                                });
                                break;
                            case 'reply-comment':
                                text = 'Yorumunuza yanıt verdi';
                                embed = createNotificationEmbed({
                                    author: {
                                        username: user['username'],
                                        text: item['details']['extend']['comment']['text']
                                    },
                                    member: {
                                        username: item['from']['username'],
                                        text: item['details']['extend']['reply']['text']
                                    }
                                });
                                break;
                            case 'comment':
                                text = 'Gönderinize bir yorum bıraktı';
                                embed = createNotificationEmbed({
                                    banner: {
                                        url: item['details']['extend']['post']['content']['url'],
                                        type: item['details']['extend']['post']['content']['type']
                                    },
                                    author: {
                                        username: user['username'],
                                        text: item['details']['extend']['post']['text']
                                    },
                                    member: {
                                        username: item['from']['username'],
                                        text: item['details']['extend']['comment']['text']
                                    }
                                });
                                break;
                            case 'invite':
                                text = 'Adlı kullanıcının davetiyle Glynet\'e katıldınız';
                                break;
                            case 'follow':
                                text = 'Seni takip etmeye başladı';
                                break;
                            case 'follow-request':
                                text = 'Seni takip etmek istiyor';
                                break;
                        }
                        if (item['from']['username'] && text !== undefined)
                            listArea.innerHTML += `
                                <div class="item">
                                    <div class="avatar">
                                        <img src="${item['from']['avatar']}" alt="">
                                    </div>
                                    <div class="details">
                                        <div class="author">
                                            <span>${item['from']['name']}</span>
                                        </div>
                                        <div class="notification-content">
                                            <span>${text}</span>
                                            ${embed !== undefined ? embed : ''}
                                        </div>
                                        <div class="date">
                                            <span>${item['details']['date']['text']}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                    });
                }
                followRequests.style.display = 'none';
                if (response.isPrivate)
                    followRequests.style.display = 'flex';
            });
        }
    }
    Glynet.Client = Client;
})(Glynet || (Glynet = {}));
var Glynet;
(function (Glynet) {
    class Stories {
        getStories() {
            let stories_area = $('.stories');
            _({
                url: 'api/@me/stories/collect',
                method: 'GET'
            }, (r) => {
                let storyData = JSON.parse(r['response']);
                let rightButton = $('.stories-right-button-container');
                if (!storyData['client'].story) {
                    stories_area.innerHTML += `
                        <div class="story-container">
                            <div class="story-content">
                                <div class="story-create-container">
                                    <div class="story-create">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="plus"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2z"/></g></g></svg>
                                    </div>
                                </div>
                                <div class="story-image pp-content">
                                    <div class="story-image-filter"></div>
                                    <img src="${storyData['client'].details.avatar}" alt="Profil resminiz">
                                </div>
                            </div>
                            <div class="story-username">
                                <span>Yeni hikaye</span>
                            </div>
                        </div>
                    `;
                }
                storyData['stories'].forEach((story) => {
                    stories_area.innerHTML += `
                        <div class="story-container">
                            <div class="story-content">
                                <div class="story-avatar">
                                    <img src="${story['user'].avatar}" alt="">
                                </div>
                                <div class="story-image">
                                    <div class="story-image-filter"></div>
                                    <img src="${story['content'].thumbnail}" alt="">
                                </div>
                            </div>
                            <div class="story-username">
                                <span>${story['user'].username}</span>
                            </div>
                        </div>
                    `;
                });
                if (!(stories_area.scrollWidth > stories_area.clientWidth)) {
                    stories_area.style.justifyContent = 'center';
                    rightButton.style.display = 'none';
                }
            });
        }
    }
    Glynet.Stories = Stories;
})(Glynet || (Glynet = {}));
var Glynet;
(function (Glynet) {
    class Posts {
        collect(type, query) {
            let requestUrl = `api/@me/posts/${type}/${query}`;
            _({ url: requestUrl, method: 'GET' }, (data) => {
                $('.post-area-ts').innerHTML = data['response'];
                this.filtersReload();
                app.clickListener();
            });
        }
        like(id) {
            let icon = $(`.post-btn-like-${id}`);
            let text = $(`.post-btn-text-like-${id} span`);
            icon.classList.toggle('icon-2');
            if (icon.classList.contains('icon-2')) {
                app.bottomAlert('Gönderi beğenildi');
                text.innerText = (parseInt(text.innerText) + 1).toString();
            }
            else {
                app.bottomAlert('Gönderiden beğeni kaldırıldı');
                text.innerText = (parseInt(text.innerText) - 1).toString();
            }
            _({
                url: `api/@me/posts/like/${id}`,
                method: 'POST'
            });
        }
        likes(id) {
            const content = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.content');
            const empty = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.empty');
            content.innerHTML = '';
            content.style.display = 'none';
            empty.style.display = 'block';
            _({
                url: `api/@me/posts/likes/${id}`,
                method: 'GET'
            }, (r) => {
                const data = JSON.parse(r['response']);
                if (!data['available'])
                    return;
                content.style.display = 'block';
                empty.style.display = 'none';
                data['data'].forEach((item) => {
                    let buttons = '';
                    if (data.isAuthor && parseInt(item['user']['id']) !== user['id']) {
                        buttons = `
                            <div @click="posts.removeLike(${id}, ${item['user']['id']})" class="button user-remove-follower-${item['user']['id']}">
                                <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="close-circle"><rect width="24" height="24" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm2.71 11.29a1 1 0 0 1 0 1.42 1 1 0 0 1-1.42 0L12 13.41l-1.29 1.3a1 1 0 0 1-1.42 0 1 1 0 0 1 0-1.42l1.3-1.29-1.3-1.29a1 1 0 0 1 1.42-1.42l1.29 1.3 1.29-1.3a1 1 0 0 1 1.42 1.42L13.41 12z"/></g></g></svg></div>
                                <div class="text"><span>Çıkar</span></div>
                            </div>
                        `;
                    }
                    content.innerHTML += `
                        <div class="user user-likes-modal-card user-profile-${item['user']['id']}">
                            <div @click="app.open('profile', { username: '${item['user']['username']}' })" class="left-side user-left-go-profile-${item['user']['id']}">
                                <div class="avatar">
                                    <img src="${item['user']['avatar']}" alt="Profil resmi">
                                </div>
                                <div class="details">
                                    <div class="name">
                                        <span>${item['user']['name']}</span> ${item['user']['isVerified'] ? '<div class="verified"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm4.3 7.61l-4.57 6a1 1 0 0 1-.79.39 1 1 0 0 1-.79-.38l-2.44-3.11a1 1 0 0 1 1.58-1.23l1.63 2.08 3.78-5a1 1 0 1 1 1.6 1.22z"></path></g></g></svg></div>' : ''}
                                    </div>
                                    <div class="username">
                                        <span>@${item['user']['username']}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="right-side">${buttons}</div>
                        </div>
                `;
                });
                app.clickListener();
            });
            app.modal('post-likes', true);
        }
        removeLike(post, user) {
            const content = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.content');
            const empty = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.empty');
            let like_count = $(`.post-btn-text-like-${post} span`);
            let count = Math.abs(parseInt(like_count.innerText) <= 0 ? 0 : parseInt(like_count.innerText) - 1);
            like_count.innerText = ($(`.post-btn-like-${post}`).classList.contains('icon-2') ? (count == 0 ? 1 : count) : count).toString();
            $(`.user-profile-${user}`).remove();
            let user_cards = $$('.user-likes-modal-card');
            if (user_cards.length == 0) {
                content.innerHTML = '';
                content.style.display = 'none';
                empty.style.display = 'block';
            }
            _({
                url: `api/@me/posts/remove_like/${post}-${user}`,
                method: 'POST'
            });
        }
        save(id) {
            let icon = $(`.post-btn-save-${id}`);
            icon.classList.toggle('icon-2');
            if (icon.classList.contains('icon-2')) {
                app.bottomAlert('Gönderi kaydedildi');
            }
            else {
                app.bottomAlert('Gönderi kaydedilenlerden kaldırıldı');
            }
            _({
                url: `api/@me/posts/save/${id}`,
                method: 'POST'
            });
        }
        muteVideo(id) {
            let video = $(`.post-video-${id}`);
            let sdOn = $(`.sd-on-${id}`);
            let sdOff = $(`.sd-off-${id}`);
            if (!video.muted) {
                app.bottomAlert('Video susturuldu');
                video.muted = true;
                sdOn.style.display = 'none';
                sdOff.style.display = 'block';
            }
            else {
                app.bottomAlert('Videonun sesi oynatılıyor');
                video.muted = false;
                sdOn.style.display = 'block';
                sdOff.style.display = 'none';
            }
        }
        delete(id, accept = false) {
            if (accept) {
                _({
                    url: `api/@me/posts/delete/${id}`,
                    method: 'POST'
                }, (r) => {
                    const data = JSON.parse(r['response']);
                    const metrics = $('html body div.app div.right div.details div.dynamic-right-panel div#box-profile-metrics.box.removable-box div.profile-metrics div.metric-data div.value');
                    if (data.success) {
                        app.bottomAlert('Gönderi silindi');
                        $('.post-' + id).remove();
                        if (metrics)
                            metrics.innerText = `${((parseInt(metrics.innerText) - 1) == -1 ? 0 : (parseInt(metrics.innerText) - 1))}`;
                    }
                    else {
                        app.bottomAlert('Gönderi silinirken bir hata meydana geldi');
                    }
                });
            }
            else {
                app.confirm('Gönderi kaldırma', 'Gönderinizi kaldırmak üzeresiniz, gönderinizi kaldırdıktan sonra asla bu işlemi geri alamazsınız. Yine de devam etmek istiyor musunuz?', ['Evet, istiyorum', 'Vazgeçtim'], `posts.delete(${id}, true)`);
            }
        }
        filter(type) {
            $$('.filter').forEach(f => f.classList.remove('selected'));
            $(`.filter-${type}`).classList.add('selected');
            $$(`.post`).forEach(p => p.style.display = (type == 'all' ? 'inline-block' : 'none'));
            if (type !== 'all')
                $$(`.post-type-${type}`).forEach(item => item.style.display = 'inline-block');
        }
        filtersReload() {
            let text = $$('.post-type-text');
            let images = $$('.post-type-image');
            let videos = $$('.post-type-video');
            let filter_container = $('.post-filter-container');
            let text_filter = $('.filter.filter-text');
            let images_filter = $('.filter.filter-image');
            let videos_filter = $('.filter.filter-video');
            let area = $('.post-listing-area');
            if (text.length == 0 && text_filter)
                text_filter.style.display = 'none';
            if (images.length == 0 && images_filter)
                images_filter.style.display = 'none';
            if (videos.length == 0 && videos_filter)
                videos_filter.style.display = 'none';
            if (text.length == 0 && images.length == 0 && videos.length == 0 && filter_container) {
                filter_container.style.display = 'none';
                area.style.columns = 'auto';
            }
        }
        menu(id) {
            let dropdowns = $$('.post-more-dropdown');
            let dropdown = $(`.post-more-dd-${id}`);
            if (activePostMenuClassList)
                dropdowns
                    .forEach(menu => {
                    menu.style.display = 'none';
                    activePostMenuClassList = false;
                });
            dropdown.style.display = 'flex';
            setTimeout(() => {
                activePostMenuClassList = true;
                console.log('Post menu active');
            }, 300);
        }
    }
    Glynet.Posts = Posts;
})(Glynet || (Glynet = {}));
var Glynet;
(function (Glynet) {
    class Profile {
        getMetrics(id, followings = true) {
            let get = 'followers';
            if (followings)
                get = 'followings';
            _({
                url: `api/@me/profile/${get}/${id}`,
                method: 'GET'
            }, (r) => {
                let data = JSON.parse(r.response);
                let area = $(`#profile-${get} .modal-content .template-5 .content`);
                let empty = $(`#profile-${get} .modal-content .template-5 .empty`);
                area.innerHTML = '';
                empty.style.display = 'flex';
                if (data.length !== 0) {
                    let buttons = '';
                    empty.style.display = 'none';
                    data.forEach(item => {
                        if (parseInt(user['id']) == id && get == 'followers') {
                            buttons = `
                                <div @click="profile.removeFollower(${item['id']})" class="button user-remove-follower-${get}-${item['id']}">
                                    <div class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="close-circle"><rect width="24" height="24" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm2.71 11.29a1 1 0 0 1 0 1.42 1 1 0 0 1-1.42 0L12 13.41l-1.29 1.3a1 1 0 0 1-1.42 0 1 1 0 0 1 0-1.42l1.3-1.29-1.3-1.29a1 1 0 0 1 1.42-1.42l1.29 1.3 1.29-1.3a1 1 0 0 1 1.42 1.42L13.41 12z"/></g></g></svg></div>
                                    <div class="text"><span>Çıkar</span></div>
                                </div>
                            `;
                        }
                        area.innerHTML += `
                            <div class="user user-profile-${get}-${item['id']}">
                                <div @click="app.open('profile', { username: '${item['username']}' })" class="left-side user-left-go-profile-${get}-${item['id']}">
                                    <div class="avatar">
                                        <img src="${item['avatar']}" alt="Profil resmi">
                                    </div>
                                    <div class="details">
                                        <div class="name">
                                            <span>${item['name']}</span> ${item['isVerified'] ? '<div class="verified"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm4.3 7.61l-4.57 6a1 1 0 0 1-.79.39 1 1 0 0 1-.79-.38l-2.44-3.11a1 1 0 0 1 1.58-1.23l1.63 2.08 3.78-5a1 1 0 1 1 1.6 1.22z"></path></g></g></svg></div>' : ''}
                                        </div>
                                        <div class="username">
                                            <span>@${item['username']}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="right-side">${buttons}</div>
                            </div>
                    `;
                    });
                }
                app.modal(`profile-${get}`, true);
                app.clickListener();
            });
        }
        removeFollower(id, accept = false) {
            if (accept) {
                let user_card = $(`.user-profile-followers-${id}`);
                let count = $('.metric-data-followers .value');
                user_card.remove();
                count.innerHTML = (parseInt(count.innerHTML) - 1).toString();
                _({
                    url: `api/@me/profile/remove_follower/${id}`,
                    method: 'POST'
                });
            }
            else {
                app.confirm('Onay', 'Sizi takip eden birisini takipçi listenizden çıkarmak üzeresiniz, bu işlem asla geri alınamaz ve kullanıcı tekrar sizi takip edebilir.', ['Çıkar', 'İptal'], `profile.removeFollower(${id}, true)`);
            }
        }
        unBlock(id, element) {
            switch (element) {
                default:
                case 'blocked-user':
                    $(`.blocked-user-${id}`).remove();
                    if ($$('.blocked-user').length == 0) {
                        $('.no-blocked-user-container').style.display = "block";
                        $('.blocked-users-list').style.display = "none";
                    }
                    break;
            }
            _({
                url: `api/@me/profile/block/${id}`,
                method: 'POST'
            });
        }
        getBlockedUsers(type = 'block') {
            _({
                url: `api/@me/profile/blocked_users/${type}`,
                method: 'GET'
            }, (r) => {
                const empty = $('.no-blocked-user-container');
                const area = $('.blocked-users-list');
                const data = JSON.parse(r['response']);
                if (data.status) {
                    area.innerHTML = "";
                    if (data.users.length == 0) {
                        empty.style.display = "block";
                        area.style.display = "none";
                    }
                    else {
                        empty.style.display = "none";
                        area.style.display = "block";
                        data.users.forEach((item) => {
                            area.innerHTML += `
                                <div class="blocked-user blocked-user-${item.user.id}">
                                    <div class="blocked-user-left">
                                        <img src="${item.user.avatar}" alt="">
                                    </div>
                                    <div class="blocked-user-right">
                                        <div class="blocked-user-details">
                                            <span>${item.user.name}</span>
                                            <span>@${item.user.username}</span>
                                        </div>
                                        <div @click="profile.unBlock(${item.user.id}, 'blocked-user')" class="blocked-user-unblock btn-${Math.floor(Math.random() * 3000) - 1} blocked-user-unblock-btn-${item.user.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="close"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"/></g></g></svg>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        app.clickListener();
                    }
                }
            });
        }
    }
    Glynet.Profile = Profile;
})(Glynet || (Glynet = {}));
const app = new Glynet.Application();
const client = new Glynet.Client();
const posts = new Glynet.Posts();
const profile = new Glynet.Profile();
const stories = new Glynet.Stories();
document.addEventListener("DOMContentLoaded", function () {
    let typingTimer;
    let doneTypingInterval = 300;
    let searchElement = $('.search .area input');
    client.startSession();
    client.setColor(doc.cookies.get('color') == undefined ? "#31e9f2" : doc.cookies.get('color'));
    client.setTheme(doc.cookies.get('theme') == undefined ? 1 : parseInt(doc.cookies.get('theme')), false);
    app.scrollToTop();
    app.clickListener();
    ui.changeFontSize(doc.cookies.get('rwRfs') ? parseInt(doc.cookies.get('rwRfs')) : 9);
    ui.changeLineHeight(doc.cookies.get('rwRlh') ? parseInt(doc.cookies.get('rwRlh')) : 7);
    window.onpopstate = () => app.router(window.location.pathname.replace("/glynet.com/", ""));
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('search-input'))
            if ($('.search-input').value.length > 0) {
                $('.search-dropdown').style.display = 'block';
                activeDropdownClassList = '.search-dropdown';
                return e.preventDefault();
            }
        if (activePostMenuClassList)
            $$('.post-more-dropdown').forEach(menu => {
                if (!menu.contains(e.target)) {
                    menu.classList.add('post-more-dropdown-hide');
                    setTimeout(() => {
                        menu.classList.remove('post-more-dropdown-hide');
                        menu.style.display = 'none';
                    }, 290);
                }
            });
        if (activeDropdownClassList)
            $$('.dropdown-container').forEach(menu => {
                if (!menu.contains(e.target) && menu.style.display == 'block') {
                    menu.classList.add((activeDropdownClassList == '.search-dropdown' ? 'search-' : '') + 'dropdown-hide');
                    setTimeout(() => {
                        menu.classList.remove((activeDropdownClassList == '.search-dropdown' ? 'search-' : '') + 'dropdown-hide');
                        menu.style.display = 'none';
                        activeDropdownClassList = '';
                    }, 300);
                }
            });
        if (e.target.classList.contains('modal'))
            app.modal(activeModalClassList, false);
    });
    searchElement.addEventListener('keyup', (e) => {
        if (e.keyCode == 13)
            return ui.desktop.searchInput.go();
        if (e.keyCode == 40) {
            ui.desktop.searchInput.down();
        }
        else if (e.keyCode == 38) {
            ui.desktop.searchInput.up();
        }
        if (e.keyCode == 40 || e.keyCode == 38)
            return;
        let dropdown = $('.search-dropdown');
        let queryKeywordElement = $('.header-search-dropdown-query-keyword');
        queryKeywordElement.innerText = ui.addDots(searchElement.value, 16);
        clearTimeout(typingTimer);
        if (searchElement.value.length > 1) {
            if (!(e.keyCode <= 90 && e.keyCode >= 48))
                return;
            dropdown.style.display = 'block';
            activeDropdownClassList = '.search-dropdown';
            typingTimer = setTimeout(() => app.search(searchElement.value), doneTypingInterval);
        }
        else {
            dropdown.classList.add('search-dropdown-hide');
            setTimeout(() => {
                dropdown.classList.remove('search-dropdown-hide');
                dropdown.style.display = 'none';
            }, 300);
        }
    });
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (doc.cookies.get('theme') !== undefined && parseInt(doc.cookies.get('theme')) == 3)
            client.setTheme(e.matches ? 2 : 1, false);
    });
});
//# sourceMappingURL=dist.js.map