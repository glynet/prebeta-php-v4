namespace Glynet
{
    export class Posts
    {
        collect(type: string, query?: string): any
        {
            let requestUrl: string = `api/@me/posts/${type}/${query}`;

            _({ url: requestUrl, method: 'GET' }, (data: object) => {
                $('.post-area-ts').innerHTML = data['response'];
                this.filtersReload();
                app.clickListener();
            });
        }

        like(id: number): void
        {
            let icon: HTMLElement = $(`.post-btn-like-${id}`);
            let text: HTMLElement = $(`.post-btn-text-like-${id} span`);

            icon.classList.toggle('icon-2');

            if (icon.classList.contains('icon-2')) {
                app.bottomAlert('Gönderi beğenildi')
                text.innerText = (parseInt(text.innerText) + 1).toString();
            } else {
                app.bottomAlert('Gönderiden beğeni kaldırıldı')
                text.innerText = (parseInt(text.innerText) - 1).toString();
            }

            _({
                url: `api/@me/posts/like/${id}`,
                method: 'POST'
            });
        }

        likes(id: number): void
        {
            const content = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.content');
            const empty = $('html body div.app modal-area div#post-likes.modal div.modal-content div.template-5 div.empty');

            content.innerHTML = '';
            content.style.display = 'none';
            empty.style.display = 'block';

            _({
                url: `api/@me/posts/likes/${id}`,
                method: 'GET'
            }, (r: object) => {
                const data = JSON.parse(r['response']);
                if (!data['available']) return;

                content.style.display = 'block';
                empty.style.display = 'none';

                data['data'].forEach((item: object) => {
                    let buttons: string = '';

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

        removeLike(post: number, user: number): void
        {
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

        save(id: number): void
        {
            let icon: HTMLElement = $(`.post-btn-save-${id}`);
            icon.classList.toggle('icon-2');

            if (icon.classList.contains('icon-2')) {
                app.bottomAlert('Gönderi kaydedildi')
            } else {
                app.bottomAlert('Gönderi kaydedilenlerden kaldırıldı')
            }

            _({
                url: `api/@me/posts/save/${id}`,
                method: 'POST'
            });
        }

        muteVideo(id: number): void
        {
            let video = <HTMLVideoElement>$(`.post-video-${id}`);
            let sdOn = <HTMLElement>$(`.sd-on-${id}`);
            let sdOff = <HTMLElement>$(`.sd-off-${id}`);

            if (!video.muted) {
                app.bottomAlert('Video susturuldu');

                video.muted = true;
                sdOn.style.display = 'none';
                sdOff.style.display = 'block';
            } else {
                app.bottomAlert('Videonun sesi oynatılıyor');

                video.muted = false;
                sdOn.style.display = 'block';
                sdOff.style.display = 'none';
            }
        }

        delete(id: number, accept: boolean = false): void
        {
            if (accept) {
                _({
                    url: `api/@me/posts/delete/${id}`,
                    method: 'POST'
                }, (r: object) => {
                    const data = JSON.parse(r['response']);
                    const metrics = $('html body div.app div.right div.details div.dynamic-right-panel div#box-profile-metrics.box.removable-box div.profile-metrics div.metric-data div.value');

                    if (data.success) {
                        app.bottomAlert('Gönderi silindi')    
                        $('.post-' + id).remove();
                        if (metrics) metrics.innerText = `${((parseInt(metrics.innerText) - 1) == -1 ? 0 : (parseInt(metrics.innerText) - 1))}`;
                    } else {
                        app.bottomAlert('Gönderi silinirken bir hata meydana geldi')
                    }
                });
            } else {
                app.confirm(
                    'Gönderi kaldırma',
                    'Gönderinizi kaldırmak üzeresiniz, gönderinizi kaldırdıktan sonra asla bu işlemi geri alamazsınız. Yine de devam etmek istiyor musunuz?',
                    ['Evet, istiyorum', 'Vazgeçtim'],
                    `posts.delete(${id}, true)`
                );
            }
        }

        filter(type: string): void
        {
            $$('.filter').forEach(f => f.classList.remove('selected'));
            $(`.filter-${type}`).classList.add('selected');

            $$(`.post`).forEach(p =>
                p.style.display = (type == 'all' ? 'inline-block' : 'none'));

            if (type !== 'all')
                $$(`.post-type-${type}`).forEach(item =>
                    item.style.display = 'inline-block');
        }

        filtersReload(): void
        {
            let text: NodeList = $$('.post-type-text');
            let images: NodeList = $$('.post-type-image');
            let videos: NodeList = $$('.post-type-video');

            let filter_container = <HTMLElement>$('.post-filter-container');
            let text_filter = <HTMLElement>$('.filter.filter-text');
            let images_filter = <HTMLElement>$('.filter.filter-image');
            let videos_filter = <HTMLElement>$('.filter.filter-video');

            let area = <HTMLElement>$('.post-listing-area');

            if (text.length == 0 && text_filter) text_filter.style.display = 'none';
            if (images.length == 0 && images_filter) images_filter.style.display = 'none';
            if (videos.length == 0 && videos_filter) videos_filter.style.display = 'none';

            if (text.length == 0 && images.length == 0 && videos.length == 0 && filter_container) {
                filter_container.style.display = 'none';
                area.style.columns = 'auto';
            }
        }

        menu(id: number): void
        {
            let dropdowns = $$('.post-more-dropdown');
            let dropdown = <HTMLElement>$(`.post-more-dd-${id}`);

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
}