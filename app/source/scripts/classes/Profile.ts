// noinspection JSStringConcatenationToES6Template

namespace Glynet
{
    export class Profile
    {
        getMetrics(id: number, followings: boolean = true): void
        {
            let get = 'followers';
            if (followings) get = 'followings';

            _({
                url: `api/@me/profile/${get}/${id}`,
                method: 'GET'
            }, (r: any) => {
                let data = JSON.parse(r.response);
                let area = $(`#profile-${get} .modal-content .template-5 .content`);
                let empty = $(`#profile-${get} .modal-content .template-5 .empty`);

                area.innerHTML = '';
                empty.style.display = 'flex';

                if (data.length !== 0) {
                    let buttons: string = '';
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

        removeFollower(id: number, accept: boolean = false): void
        {
            if (accept) {
                let user_card: HTMLElement = $(`.user-profile-followers-${id}`);
                let count: HTMLElement = $('.metric-data-followers .value');

                user_card.remove();
                count.innerHTML = (parseInt(count.innerHTML) - 1).toString();

                _({
                    url: `api/@me/profile/remove_follower/${id}`,
                    method: 'POST'
                });
            } else {
                app.confirm(
                    'Onay',
                    'Sizi takip eden birisini takipçi listenizden çıkarmak üzeresiniz, bu işlem asla geri alınamaz ve kullanıcı tekrar sizi takip edebilir.',
                    ['Çıkar', 'İptal'],
                    `profile.removeFollower(${id}, true)`
                );
            }
        }
    }
}