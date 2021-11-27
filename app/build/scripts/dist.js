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
const ui = {
    addDots: (string, limit) => {
        let dots = "...";
        if (string.length > limit)
            string = string.substring(0, limit) + dots;
        return string;
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
            $$("div, span, img").forEach((elem) => {
                let click = elem.getAttribute("@click");
                if ((click === null || click === void 0 ? void 0 : click.length) > 0 || click !== null) {
                    const classname = `.${[].slice.apply(elem.classList).join('.')}`;
                    $$$(classname, () => eval(click));
                    $(classname).removeAttribute("@click");
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
            }
            let inp = $('.clipboard label input');
            inp.value = text;
            inp.focus();
            inp.select();
            document.execCommand('copy');
            this.bottomAlert(alert);
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
                this.confirm('Yönlendirme', 'Gitmek üzere olduğunuz internet sitesinin Glynet ile uzaktan veya yakından bağlantısı bulunmamaktadır. Oluşabilecek herhangi bir güvenlik ihmaline karşın dikkatli olmanızı öneririz.', ['Anladım', 'Geri dön'], "app.openExternal('" + url + "', true)");
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
                                <div class="story-image">
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