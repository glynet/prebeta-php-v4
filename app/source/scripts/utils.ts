interface Array<T> {
    includes<U>(searchElement: U, fromIndex?: number): U extends T ? boolean : false;
}

interface String {
    uiRepair: () => any;
    replaceAll: (search: string, replacement: string) => any;
}

interface Object {
    case: (value: string) => any;
}

String.prototype.uiRepair = function() {
    return this.toString().replace(/\\/g, "").split("{/quotes}").join("'");
}

// @ts-ignore
String.prototype.replaceAll = function(search, replacement) {
    let target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

Object.prototype.case = function(v) {
    if (this.hasOwnProperty(v)) {
        if (typeof this[v] === 'function') {
            return this[v]();
        } else {
            return this[v];
        }
    }
}

let user: object = {};
let lastPage: object = { name: "", data: {} };
let bottomAlertTimeout: any;
let activeModalClassList: string = '';
let activeDropdownClassList: string = '';
let activePostMenuClassList: boolean = false;
let searchSuggestionsSelectedItem: number = 0;

const ui = {
    addDots: (string: string, limit: number) => {
        let dots = "...";

        if (string.length > limit)
            string = string.substring(0, limit) + dots;

        return string;
    },
    color: {
        changeBrightness: (color,  percent) => {
            let num = parseInt(color.replace("#",""),16),
                amt = Math.round(2.55 * percent),
                R = (num >> 16) + amt,
                B = (num >> 8 & 0x00FF) + amt,
                G = (num & 0x0000FF) + amt;

            return "#" + (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (B<255?B<1?0:B:255)*0x100 + (G<255?G<1?0:G:255)).toString(16).slice(1);
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
            select: (count: number) => {
                $$('.search-result-other').forEach(item => item.classList.remove('search-result-selected'))
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
            toggle: (name: string) => {
                let dd: HTMLElement = $(name);

                if (activeDropdownClassList == name) {
                    dd.classList.add('dropdown-hide');
                    activeDropdownClassList = '';

                    setTimeout(() => {
                        dd.classList.remove('dropdown-hide');
                        dd.style.display = 'none';
                    }, 300);
                } else {
                    dd.style.display = 'block';
                    setTimeout(() => activeDropdownClassList = name, 300);
                }
            },
            hide: (name: string) => {
                let dd: HTMLElement = $(name);

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
            scroll: (left: boolean = false) => {
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
                        setTimeout(() => rightButton.style.display = 'none', 100)
                    }
                } else {
                    rightButton.style.display = 'flex';
                    rightButton.style.opacity = '1';

                    if ((container.scrollLeft - 500) <= 350) {
                        container.scrollLeft = 0;
                    } else {
                        container.scrollLeft = (container.scrollLeft - 500);
                    }

                    if ((container.scrollLeft - 500) < 0 || (container.scrollLeft - 500) == 0) {
                        leftButton.style.opacity = '0';
                        setTimeout(() => leftButton.style.display = 'none', 100)
                    }
                }
            },
            get: () => {
                let categories_area = $('.categories');

                _({
                    url: 'api/@me/explore/categories/collect',
                    method: 'GET'
                }, (r: object) => {
                    let categoriesData = JSON.parse(r['response']);
                    let rightButton = $('.categories-right-button-container');

                    categoriesData.forEach((category: object) => {
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
                    .forEach(item =>
                        item.classList.remove('selected')
                    );
            },
            select: (id: string, auto: boolean = true) => {
                let menuItem = $('.menu-' + id);
                ui.desktop.left.unselect();

                if (menuItem) menuItem.classList.add('selected');
                if (auto) app.open(id);
            }
        },
        right: {
            parseItems: () => {
                let append_data = $('right-panel');
                let dynamic_panel = $('.dynamic-right-panel');

                // @ts-ignore
                if (append_data && dynamic_panel) {
                    dynamic_panel.innerHTML = append_data.innerHTML.replaceAll('@create_click', '@click');

                    dynamic_panel.style.display = 'block';
                    append_data.innerHTML = '';
                    app.clickListener();
                }
            }
        }
    }
}

const doc = {
    cookies: {
        set: (name: string, value: string, days: number) => {
            let expires = "";

            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }

            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        },
        get: (name: string) => {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    }
}

const $ = (name: string) => <HTMLElement>window.document.querySelector(name);

const $$ = (name: string) => window.document.querySelectorAll<HTMLElement>(name);

const $$$ = (name: string, callback: any) => $(name).onclick = callback;

const _ = ({ url, method = "GET", data = {} }, callback: any = null) => {
    const request = new XMLHttpRequest();

    const urlParams =
        Object.keys(data)
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
    }

    request.send();
}

function switchMatch(s: object) {
    return s;
}