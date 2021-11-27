namespace Glynet
{
    export class Application
    {
        changeUrl(title: string): void
        {
            window.history.pushState(null, null, title);
        }
    
        newTitle(title: string): void
        {
            window.document.title = title;
        }
    
        search(query: string): void
        {
            _({
                url: 'api/@me/search/suggestions?q=' + query,
                method: 'GET'
            }, (r: object) => {
                const data = JSON.parse(r['response']);
                let container = $('.search-items');
                
                container.innerHTML = "";
                
                data.forEach((item: object) => {
                    let icon: string;
                    let click: string;
    
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

        clickListener(): void
        {
            $$("div, span, img").forEach((elem: HTMLElement) => {
                let click = elem.getAttribute("@click");

                if (click?.length > 0 || click !== null) {
                    const classname = `.${[].slice.apply(elem.classList).join('.')}`;
                    $$$(classname, () => eval(click));
                    $(classname).removeAttribute("@click");
                }
            });
        }
    
        copyClipboard(text: string, alertType: number): void
        {
            let alert: string = '';
    
            switch (alertType) {
                case 0: alert = 'Sayfa bağlantısı panoya kopyalandı!'; break;
                case 1: alert = 'Gönderi bağlantısı panoya kopyalandı'; break;
            }
    
            let inp = <HTMLInputElement>$('.clipboard label input');
            inp.value = text;
            inp.focus();
            inp.select();
            document.execCommand('copy');
            this.bottomAlert(alert);
        }
    
        open(name: string, data: object = {}): void
        {
            const body = $('body .app .center main#content');
            ui.desktop.left.select(name, false);
    
            if (name == lastPage['name']) {
                if (JSON.stringify(data) == JSON.stringify(lastPage['data'])) return;
            } else if (name == 'myprofile') {
                name = 'profile';
                data = { username: user['username'], user_id: parseInt(user['id']) };
            }
    
            if (name == 'profile' && data['user_id'] == parseInt(user['id'])) ui.desktop.left.select('myprofile', false);
    
            lastPage = { name, data };
    
            $$('.removable-box').forEach(e => {
                app.anim(e, { opacity: 0 }, 300);
    
                setTimeout(() => {
                    e.remove();
                    $('.dynamic-right-panel').style.display = 'none';
                }, 300)
            });
    
            app.anim(body, { padding: '20px', opacity: '0' }, 300);
    
            _({ url: 'pages/' + name, method: 'GET', data }, (r: object) => {
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
    
        openExternal(url: string, accept: boolean = false): void
        {
            if (accept) {
                window.open(`mommycanigoout/?r=${btoa(url)}`, '_blank');
            } else {
                this.confirm(
                    'Yönlendirme',
                    'Gitmek üzere olduğunuz internet sitesinin Glynet ile uzaktan veya yakından bağlantısı bulunmamaktadır. Oluşabilecek herhangi bir güvenlik ihmaline karşın dikkatli olmanızı öneririz.',
                    ['Anladım', 'Geri dön'],
                    "app.openExternal('" + url + "', true)"
                );
            }
        }
    
        router(url: string): any
        {
            url = decodeURIComponent(url);
    
            if (url.split("").includes("/")) {
                const key = url.split("/")[0];
                const data = url.split("/")[1];
    
                switch (key) {
                    case "profile":
                        this.open('profile', { username: data });
                        break;
                }
            } else if (url.split("").includes("@")) {
                this.open('profile', { username: url.split("@")[1] });
            } else {
                this.open((url.replace(/\s/g, "") == "" ? "feed" : url));
            }
        }
    
        anim(elem: any, style: object, duration: number = 50): void
        {
            let oldTransitionDuration = elem.style.transitionDuration;
            elem.style.transitionDuration = `${duration}ms`;
    
            setTimeout(() => {
                Object.entries(style).forEach(e => {
                    elem.style[e[0]] = e[1];
                });
    
                setTimeout(() => elem.style.transitionDuration = oldTransitionDuration, duration);
            }, 100);
        }
    
        scrollToTop(element: string = ".app", duration: number = 300): void
        {
            let scrollElement = $(element);
            if (scrollElement.scrollTop === 0)
                return;
    
            const cosParameter = scrollElement.scrollTop / 2;
            let scrollCount = 0, oldTimestamp = null;
    
            function step(newTimestamp: number) {
                if (oldTimestamp !== null) {
                    scrollCount += Math.PI * (newTimestamp - oldTimestamp) / duration;
    
                    if (scrollCount >= Math.PI) return scrollElement.scrollTop = 0;
                    scrollElement.scrollTop = cosParameter + cosParameter * Math.cos(scrollCount);
                }
    
                oldTimestamp = newTimestamp;
                window.requestAnimationFrame(step);
            }
    
            window.requestAnimationFrame(step);
        }
    
        bottomAlert(text: string): void
        {
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
    
        confirm(title: string, desc: string, buttons?: any, callback?: any): void
        {
            let modalArea = <HTMLElement>$('modal-area');
            let confirmId: number = Math.floor(Math.random() * 9800) + 1;
    
            let newModal: string = `
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
    
        follow(id: number, type: number): void
        {
            // 1: Profile, 2: Modal...
    
            switch (type) {
                case 1:
                    let button: HTMLElement = $(`.profile-btn-flw-${id}`);
                    let count: HTMLElement = $(`#box-profile-metrics > div > div.metric-data-followers-${id}.metric-data > div.value`);
    
                    if (button.classList.contains('follow-btn')) {
                        this.bottomAlert('Takipten çıkıldı');
                        button.classList.remove('follow-btn');
                        count.innerHTML = (parseInt(count.innerHTML) - 1).toString();
                    } else {
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
    
        modal(id: string, open: boolean): void
        {
            if (open) {
                $$('.modal').forEach(m => m.style.display = 'none');
    
                let m = <HTMLElement>$(`#${id}`);
                let m_content = <HTMLElement>$(`#${id} .modal-content`);
    
                activeModalClassList = id;
                m_content.style.display = 'block';
                m.style.display = 'flex';
            } else {
                let m = <HTMLElement>$(`#${id}`);
                let m_content = <HTMLElement>$(`#${id} .modal-content`);
    
                m_content.classList.add('modal-hide');
    
                setTimeout(() => {
                    m.style.display = 'none';
                    m_content.style.display = 'none';
                    m_content.classList.remove('modal-hide');
                }, 200);
            }
        }
    }
}