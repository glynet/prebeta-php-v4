namespace Glynet
{
    export class Client
    {
        startSession(): void
        {
            _({
                url: 'api/@me/client',
                method: 'GET'
            }, (r: object) => {
                user = JSON.parse(r['response']);

                $$('.pp-content img')
                    .forEach((img: HTMLImageElement) => img.src = user['avatar']);
                
                this.setColor(user['color']);
                this.setTheme(user['theme'], false);
            });

            this.getRank();
            app.router(window.location.pathname.replace("/glynet.com/", ""));
        }

        getRank(): void
        {
            _({
                url: 'api/@me/client/level',
                method: 'GET'
            }, (r: object) => {
                let road: HTMLElement = $('#box-fixed-header > div > div.rank > div > div.road > div');
                let title: HTMLElement = $('#box-fixed-header > div > div.rank > div > div.text > span:nth-child(2)');
                let data: object = JSON.parse(r['response']);

                road.style.width = `${data['percent']}%`;
                title.innerHTML = `${data['level']} / ${data['level'] + 1}`;
            });
        }

        setColor(code: string): void
        {
            doc.cookies.set('user_color', code, 300);
            
            document.documentElement.style.setProperty('--app-color', code);
            document.documentElement.style.setProperty('--app-color-x1', ui.color.changeBrightness(code, -10));
            document.documentElement.style.setProperty('--app-color-s1', ui.color.changeBrightness(code, 50));
            document.documentElement.style.setProperty('--app-color-trans', ui.color.hexToRgba(code, .5));
        }

        setTheme(type: number = 3, update: boolean = true): void
        {
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
                } else if (type == 4) {
                    htmlElement.classList.value = 'theme-purple';
                } else {
                    htmlElement.classList.value = 'theme-light';
                }
                
                $$('.theme-section-dropdown-button').forEach(item => item.removeAttribute('selected'));
                
                if ($$('.theme-section-dropdown-button')[type - 1]) {
                    let selectElement = (type - 1);
                    if (parseInt(doc.cookies.get('theme')) == 3) selectElement = 2;
                    $$('.theme-section-dropdown-button')[selectElement].setAttribute('selected', '');
                }
            }
        }

        notifications(): void {
            _({
                url: 'api/@me/notifications',
                method: 'GET'
            }, (r: object) => {
                let response = JSON.parse(r['response']);
                let followRequests = $('.notifications-content div.content div.follow-requests');
                let listArea = $('.notifications-content div.content div.list');
                let emptyMessage = $('.notifications-content div.empty');

                if (response.notifications.length !== 0) {
                    emptyMessage.style.display = 'none';
                    listArea.innerHTML = '';

                    response.notifications.forEach((item: any) => {
                        let text: string;
                        let embed: string;

                        function createNotificationEmbed(obj) {
                            let member_content: string;
                            let post_content: string;

                            if ((obj.banner !== undefined ? (obj.banner.url !== undefined) : false))
                                post_content = `
                                    <div class="post-content">
                                        ${
                                        obj?.banner.url == '' ?
                                            '' :
                                            obj?.banner.type == 'image' ?
                                                `<img src="${obj?.banner.url}" alt="">` :
                                                `<video src="${obj?.banner.url}" autoplay loop muted></video>`
                                    }
                                    </div>
                                `;

                            if ((obj.member !== undefined ? (obj.member.username !== undefined) : false))
                                member_content = `
                                    <div class="post-author">
                                        <div class="arrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="corner-down-right"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"/><path d="M19.78 12.38l-4-5a1 1 0 0 0-1.56 1.24l2.7 3.38H8a1 1 0 0 1-1-1V6a1 1 0 0 0-2 0v5a3 3 0 0 0 3 3h8.92l-2.7 3.38a1 1 0 0 0 .16 1.4A1 1 0 0 0 15 19a1 1 0 0 0 .78-.38l4-5a1 1 0 0 0 0-1.24z"/></g></g></svg>
                                        </div>
                                        <div class="author">
                                            <span>${obj?.member.username}</span>
                                            <span>${ui.addDots(obj?.member.text, 16)}</span>
                                        </div>
                                    </div>
                                `;

                            return `
                                <div class="embed-container">
                                    <div class="post">
                                        ${post_content !== undefined ? post_content : ''}
                                        <div class="post-text">
                                            ${
                                                obj?.author.text == '' && (obj.member !== undefined && obj?.member?.username !== '') ?
                                                    '' :
                                                    `
                                            <div class="post-author">
                                                <div class="author">
                                                    <span>${obj?.author.username}</span>
                                                    <span>${ui.addDots(obj?.author.text, 16)}</span>
                                                </div>
                                            </div>
                                                    `
                                            }
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
                                        url: item?.details?.extend?.details?.content?.url,
                                        type: item?.details?.extend?.details?.content?.type,
                                    },
                                    author: {
                                        username: user['username'],
                                        text: item?.details?.extend?.details?.text
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
                                        url: item?.details?.extend?.details?.content?.url,
                                        type: item?.details?.extend?.details?.content?.type,
                                    },
                                    author: {
                                        username: item?.from?.username,
                                        text: item?.details?.extend?.details?.text
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
                                        url: item?.details?.extend?.details?.content?.url,
                                        type: item?.details?.extend?.details?.content?.type,
                                    },
                                    author: {
                                        username: item?.from?.username,
                                        text: item?.details?.extend?.details?.text
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
}