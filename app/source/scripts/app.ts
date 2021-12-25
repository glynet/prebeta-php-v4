const app = new Glynet.Application();
const client = new Glynet.Client();
const posts = new Glynet.Posts();
const profile = new Glynet.Profile();
const stories = new Glynet.Stories();

document.addEventListener("DOMContentLoaded", function() {
    let typingTimer: any;
    let doneTypingInterval: number = 300;
    let searchElement = <HTMLInputElement>$('.search .area input');

    client.startSession();
    client.setColor(doc.cookies.get('color') == undefined ? "#31e9f2" : doc.cookies.get('color'));
    client.setTheme(doc.cookies.get('theme') == undefined ? 1 : parseInt(doc.cookies.get('theme')), false);
    app.scrollToTop();
    app.clickListener();

    ui.changeFontSize(parseInt(doc.cookies.get('rwRfs')));
    ui.changeLineHeight(parseInt(doc.cookies.get('rwRlh')));

    app.settings(2);
    setTimeout(() => app.settings(2), 300)

    window.onpopstate = () =>
        app.router(window.location.pathname.replace("/glynet.com/", ""));

    document.addEventListener('click', (e: any) => {
        if (e.target.classList.contains('search-input'))
            if (($('.search-input') as HTMLInputElement).value.length > 0) {
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

    searchElement.addEventListener('keyup', (e: any) => {
        if (e.keyCode == 13)
            return ui.desktop.searchInput.go();

        if (e.keyCode == 40) {
            ui.desktop.searchInput.down();
        } else if (e.keyCode == 38) {
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
        } else {
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