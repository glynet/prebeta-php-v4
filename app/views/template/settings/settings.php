<div class="settings-details-container" data-category="1" data-tab="1" data-group="1">
    <div class="container-group">
        <div @click="app.settings(2)" class="big-buttons account-edit-profile">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="edit"><rect width="24" height="24" opacity="0"/><path d="M19.4 7.34L16.66 4.6A2 2 0 0 0 14 4.53l-9 9a2 2 0 0 0-.57 1.21L4 18.91a1 1 0 0 0 .29.8A1 1 0 0 0 5 20h.09l4.17-.38a2 2 0 0 0 1.21-.57l9-9a1.92 1.92 0 0 0-.07-2.71zM16 10.68L13.32 8l1.95-2L18 8.73z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Profili düzenle</span>
                <span>Profil fotoğrafınızı, profil afişinizi, adınızı vs.. özelleştirin</span>
            </div>
        </div>
        <div @click="app.settings(1,2,1,'E-Posta')" class="big-buttons account-change-mail">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="email"><rect width="24" height="24" opacity="0"/><path d="M19 4H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm0 2l-6.5 4.47a1 1 0 0 1-1 0L5 6z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>E-Posta</span>
                <span>Gerçerli e-posta adresinizi görüntüleyin veya güncelleştirin</span>
            </div>
        </div>
        <div @click="app.settings(1,3,1,'Telefon numaranız')" class="big-buttons account-change-phone">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"/><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Telefon numaranız</span>
                <span>Geçerli telefon numaranızı görüntüleyin veya güncelleştirin</span>
            </div>
        </div>
        <div @click="app.settings(1,4,1,'Engellenen Kişiler'); profile.getBlockedUsers();" class="big-buttons account-blocks">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="slash"><rect width="24" height="24" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm8 10a7.92 7.92 0 0 1-1.69 4.9L7.1 5.69A7.92 7.92 0 0 1 12 4a8 8 0 0 1 8 8zM4 12a7.92 7.92 0 0 1 1.69-4.9L16.9 18.31A7.92 7.92 0 0 1 12 20a8 8 0 0 1-8-8z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Engellenen kişiler</span>
                <span>Glynet'te engellediğiniz kişiler</span>
            </div>
        </div>
        <div @click="app.settings(6)" class="big-buttons account-change-language">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="globe"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M22 12A10 10 0 0 0 12 2a10 10 0 0 0 0 20 10 10 0 0 0 10-10zm-2.07-1H17a12.91 12.91 0 0 0-2.33-6.54A8 8 0 0 1 19.93 11zM9.08 13H15a11.44 11.44 0 0 1-3 6.61A11 11 0 0 1 9.08 13zm0-2A11.4 11.4 0 0 1 12 4.4a11.19 11.19 0 0 1 3 6.6zm.36-6.57A13.18 13.18 0 0 0 7.07 11h-3a8 8 0 0 1 5.37-6.57zM4.07 13h3a12.86 12.86 0 0 0 2.35 6.56A8 8 0 0 1 4.07 13zm10.55 6.55A13.14 13.14 0 0 0 17 13h2.95a8 8 0 0 1-5.33 6.55z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Dil seçenekleri</span>
                <span>Merhaba, Hello, Hallo, Salam...</span>
            </div>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div @click="app.settings(1,5,1,'Parola değiştir')" class="big-buttons account-change-password" data-low-opacity>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="shield"><rect width="24" height="24" opacity="0"/><path d="M12 21.85a2 2 0 0 1-1-.25l-.3-.17A15.17 15.17 0 0 1 3 8.23v-.14a2 2 0 0 1 1-1.75l7-3.94a2 2 0 0 1 2 0l7 3.94a2 2 0 0 1 1 1.75v.14a15.17 15.17 0 0 1-7.72 13.2l-.3.17a2 2 0 0 1-.98.25z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Parola değiştir</span>
                <span>Geçerli parolanızı değiştirin</span>
            </div>
        </div>
        <div @click="app.settings(1,3,1,'Hesabımı sil')" class="big-buttons account-destroy" data-low-opacity>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="trash"><rect width="24" height="24" opacity="0"/><path d="M21 6h-5V4.33A2.42 2.42 0 0 0 13.5 2h-3A2.42 2.42 0 0 0 8 4.33V6H3a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2zM10 4.33c0-.16.21-.33.5-.33h3c.29 0 .5.17.5.33V6h-4z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Hesabımı sil</span>
                <span>Boom! Glynet hesabınızı imha edin</span>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="1" data-tab="2" data-group="1">
    <div class="container-group">
        <div class="account-settings account-settings-top-email">
            <div class="top-title">
                <div class="title">
                    <span>Gerçeli e-posta adresiniz</span>
                </div>
                <div class="description account-settings-description-number">
                    <span class="settings-update-account-email-preview-input">metehansaral@glynet.com</span>
                    <div class="copy-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="copy"><rect width="24" height="24" opacity="0"/><path d="M18 21h-6a3 3 0 0 1-3-3v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3zm-6-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1z"/><path d="M9.73 15H5.67A2.68 2.68 0 0 1 3 12.33V5.67A2.68 2.68 0 0 1 5.67 3h6.66A2.68 2.68 0 0 1 15 5.67V9.4h-2V5.67a.67.67 0 0 0-.67-.67H5.67a.67.67 0 0 0-.67.67v6.66a.67.67 0 0 0 .67.67h4.06z"/></g></g></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Yeni e-posta adresiniz</div>
                <div class="container-group-description">Yeni bir e-posta adresi girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="text" placeholder="Yeni e-posta" class="settings-update-account-email-input">
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Şifreniz</div>
                <div class="container-group-description">Hesabınızın şifresini girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="password" autocomplete="false" placeholder="Şifreniz" class="settings-update-account-email-password-input">
                <span @click="client.updateAccountPreferences(0);" class="soft-button settings-update-account-email">Güncelle</span>
            </label>

            <div class="tip">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="bulb"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 7a5 5 0 0 0-3 9v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a5 5 0 0 0-3-9z"/><path d="M12 6a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1z"/><path d="M21 11h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M5 11H3a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M7.66 6.42L6.22 5a1 1 0 0 0-1.39 1.47l1.44 1.39a1 1 0 0 0 .73.28 1 1 0 0 0 .72-.31 1 1 0 0 0-.06-1.41z"/><path d="M19.19 5.05a1 1 0 0 0-1.41 0l-1.44 1.37a1 1 0 0 0 0 1.41 1 1 0 0 0 .72.31 1 1 0 0 0 .69-.28l1.44-1.39a1 1 0 0 0 0-1.42z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Bilgilendirme</span>
                    <span>E-posta adresinizi değiştirdiğiniz taktirde yeniden doğrulamanız gerekecektir</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="1" data-tab="3" data-group="1">
    <div class="container-group">
        <!--suppress CssInvalidAtRule -->
        <div class="account-settings account-settings-top-phone-number" style="@if(%user['number'] == '') display: none; @endif">
            <div class="top-title">
                <div class="title">
                    <span>Gerçeli telefon numaranız</span>
                </div>
                <div class="description account-settings-description-number">
                    <span class="settings-update-account-phone-preview-input">{{ %user['number'] }}</span>
                    <div class="copy-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="copy"><rect width="24" height="24" opacity="0"/><path d="M18 21h-6a3 3 0 0 1-3-3v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6a3 3 0 0 1-3 3zm-6-10a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1z"/><path d="M9.73 15H5.67A2.68 2.68 0 0 1 3 12.33V5.67A2.68 2.68 0 0 1 5.67 3h6.66A2.68 2.68 0 0 1 15 5.67V9.4h-2V5.67a.67.67 0 0 0-.67-.67H5.67a.67.67 0 0 0-.67.67v6.66a.67.67 0 0 0 .67.67h4.06z"/></g></g></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Yeni telefon numaranız</div>
                <div class="container-group-description">Kayıtlı telefon numaranızı yeni numaranız ile değiştirin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="text" placeholder="Yeni telefon numarası" class="settings-update-account-phone-input">
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Şifreniz</div>
                <div class="container-group-description">Hesabınızın şifresini girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="password" autocomplete="false" placeholder="Şifreniz" class="settings-update-account-phone-password-input">
                <span @click="client.updateAccountPreferences(1);" class="soft-button settings-update-account-phone">Güncelle</span>
            </label>

            <div class="tip">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="bulb"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 7a5 5 0 0 0-3 9v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a5 5 0 0 0-3-9z"/><path d="M12 6a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1z"/><path d="M21 11h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M5 11H3a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M7.66 6.42L6.22 5a1 1 0 0 0-1.39 1.47l1.44 1.39a1 1 0 0 0 .73.28 1 1 0 0 0 .72-.31 1 1 0 0 0-.06-1.41z"/><path d="M19.19 5.05a1 1 0 0 0-1.41 0l-1.44 1.37a1 1 0 0 0 0 1.41 1 1 0 0 0 .72.31 1 1 0 0 0 .69-.28l1.44-1.39a1 1 0 0 0 0-1.42z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Bilgilendirme</span>
                    <span>Telefon numaranızı değiştirdiğiniz taktirde yeniden doğrulamanız gerekecektir</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="1" data-tab="5" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Şifreniz</div>
                <div class="container-group-description">Kullanmış olduğunuz şifreyi girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="password" autocomplete="false" placeholder="Şifreniz" class="settings-change-password-input-old-password">
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Yeni şifreniz</div>
                <div class="container-group-description">Güncellemek istediğiniz şifreyi girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="password" autocomplete="false" placeholder="Yeni şifre" class="settings-change-password-input-new-password">
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title" data-required>Yeni şifrenizin tekrarlayın</div>
                <div class="container-group-description">Güncellemek istediğiniz şifreyi tekrardan girin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label>
                <input type="password" autocomplete="false" placeholder="Yeni şifrenizi tekrarlayın" class="settings-change-password-input-again-password">
                <span @click="client.updatePassword();" class="soft-button settings-update-account-password">Güncelle</span>
            </label>

            <div class="tip">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="bulb"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 7a5 5 0 0 0-3 9v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a5 5 0 0 0-3-9z"/><path d="M12 6a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1z"/><path d="M21 11h-2a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M5 11H3a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2z"/><path d="M7.66 6.42L6.22 5a1 1 0 0 0-1.39 1.47l1.44 1.39a1 1 0 0 0 .73.28 1 1 0 0 0 .72-.31 1 1 0 0 0-.06-1.41z"/><path d="M19.19 5.05a1 1 0 0 0-1.41 0l-1.44 1.37a1 1 0 0 0 0 1.41 1 1 0 0 0 .72.31 1 1 0 0 0 .69-.28l1.44-1.39a1 1 0 0 0 0-1.42z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Bilgilendirme</span>
                    <span>Şifreniz; sizin her şeyiniz. Saldırganlar tarafından kolayca bulunanamaması için kısa ve kolay çözülebilecek (ör. 12345678 gibi) şifreler koymayın.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="1" data-tab="4" data-group="1">
    <div class="blocked-users">
        <div class="no-blocked-user-container" style="display: none">
            <div class="no-blocked-user">
                <div class="icon">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 672.5315 738.39398" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M730.73425,230.607c-46.62012-7.44-99.71-11.41-155-11.41-50.6001,0-99.3501,3.32-142.98,9.58.01026-.67005.02-1.34.04981-2.01a148.99943,148.99943,0,0,1,297.91015,1.82C730.72449,229.267,730.73425,229.937,730.73425,230.607Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><g opacity="0.1"><path d="M601.28454,82.14432A149.04745,149.04745,0,0,0,432.35339,225.373c-.03027.67-.04,1.34-.0498,2.01,12.96191-1.85981,26.38476-3.4535,40.165-4.78431A149.02172,149.02172,0,0,1,601.28454,82.14432Z" transform="translate(-263.73425 -80.80301)" fill="#fff"/></g><path d="M795.91443,242.427a600.121,600.121,0,0,0-65.2002-13.84,943.3639,943.3639,0,0,0-108.73974-10.45c-15.17041-.62-30.62012-.94-46.24024-.94-12.37988,0-24.66015.2-36.77.6a973.28988,973.28988,0,0,0-106.16015,8.97,624.29224,624.29224,0,0,0-77.25,15.66c-59.21,16.37-91.81983,38.31-91.81983,61.77s32.60987,45.4,91.81983,61.77c41.64013,11.52,92.98,19.37,148.92041,22.97,23.08984,1.5,46.96,2.26,71.25976,2.26,24.37988,0,48.33008-.77,71.49024-2.27,50.90966-3.29,98.00976-10.1,137.42968-20,.21-.06.41016-.11.62012-.16,2.66016-.66,5.27979-1.35,7.87012-2.04.92969-.26,1.84961-.51,2.77-.76a.97843.97843,0,0,1,.15967-.05c.88037-.24,1.75-.49,2.62011-.73,1.74024-.5,3.46-.99,5.14991-1.5.08007-.02.1499-.04.22021-.06,1.46973-.44,2.91016-.88,4.33984-1.32,1.16993-.37,2.33008-.73,3.48-1.1q1.26051-.405,2.49024-.81c.6001-.2,1.18994-.39,1.77-.59.79-.26,1.58008-.53,2.35986-.8.33008-.11.66016-.22.98-.34.75-.25,1.48-.51,2.21-.77.79-.28,1.58008-.57,2.35987-.85.65039-.23,1.30029-.47,1.93994-.71.54-.21,1.07031-.41,1.61035-.61,1.46973-.55,2.91016-1.12006,4.33008-1.68.71-.29,1.41992-.57,2.11963-.86.68994-.28,1.39013-.57,2.07031-.86q1.67944-.70506,3.2998-1.41c.52-.24,1.0503-.47,1.56006-.68994.39014-.18.77-.35,1.16016-.53.27978-.12.56006-.25.83008-.38,1.00976-.46,2.00976-.93,2.98974-1.4q5.64039-2.7,10.52979-5.52c20.45019-11.71,31.24023-24.7,31.24023-38.2C887.73425,280.737,855.12439,258.797,795.91443,242.427Zm-.54,121.62c-41.68994,11.53-93.16992,19.38-149.26026,22.95-22.81005,1.45-46.38964,2.2-70.37988,2.2-23.91015,0-47.41015-.74-70.1499-2.19-56.18018-3.56-107.74023-11.41-149.49023-22.96-58.27-16.12-90.35987-37.37-90.35987-59.85a24.11774,24.11774,0,0,1,.74024-5.89c5.09961-20.28,36.46972-39.26,89.61963-53.96a623.80606,623.80606,0,0,1,76.66015-15.57,976.02713,976.02713,0,0,1,106.79981-9q17.88061-.585,36.18017-.58c15.41016,0,30.6499.31,45.62988.91a941.36713,941.36713,0,0,1,109.37012,10.5A598.85754,598.85754,0,0,1,795.37439,244.347c53.14014,14.7,84.5,33.67,89.60986,53.94a23.82213,23.82213,0,0,1,.75,5.91C885.73425,326.677,853.64441,347.927,795.37439,364.047Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M887.16443,305.107c0,13.36005-11.01026,26-30.67041,37.29-3.26953,1.88-6.78955,3.72-10.52979,5.52-.98.47-1.98.94-2.98974,1.4-.27.13-.5503.26-.83008.38-.39014.18-.77.35-1.16016.53-.50976.22-1.04.45-1.56006.68994q-1.6201.705-3.2998,1.41c-.68018.29-1.38037.58-2.07031.86-.69971.29-1.40967.57-2.11963.86-1.41992.56-2.86035,1.13-4.33008,1.68-.54.2-1.07031.4-1.61035.61-.63965.24-1.28955.48-1.93994.71-.77979.28-1.56983.57-2.35987.85-.73.26-1.46.52-2.21.77-.31982.12006-.6499.23-.98.34-.77978.27-1.56982.54-2.35986.8-.58008.2-1.16992.39-1.77.59q-1.23046.40494-2.49024.81c-1.1499.37-2.31.73-3.48,1.1-1.42968.44-2.87011.88-4.33984,1.32-.07031.02-.14014.04-.22021.06-1.68995.51-3.40967,1-5.14991,1.5-.87011.24-1.73974.49-2.62011.73a.97843.97843,0,0,0-.15967.05c-.92041.25-1.84033.5-2.77.76-2.58008.68-5.21,1.37-7.87012,2.04-.21.05-.41016.1-.62012.16-38.35009,9.58-85.3999,16.56-137.46972,19.93-22.81006,1.47-46.59033,2.25-71.02,2.25-24.6499,0-48.63037-.79-71.62012-2.29-137.24023-8.95-239.37988-43.03-239.37988-83.71a25.07169,25.07169,0,0,1,1.11963-7.3c.06006.17.12011.33.19043.5,14.26953,37.48,115.54,67.77,246.93994,75.16,20.12988,1.13995,40.98,1.73,62.31982,1.73,21.43018,0,42.35987-.6,62.56983-1.74,131.29-7.42,232.46045-37.72,246.68017-75.17q.36036-.90006.62988-1.8A25.30451,25.30451,0,0,1,887.16443,305.107Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M355.40356,294.343c-16.6427,0-34.33068-3.58057-34.33068-10.2168s17.688-10.2168,34.33068-10.2168,34.33069,3.58057,34.33069,10.2168S372.04626,294.343,355.40356,294.343Zm0-18.4336c-19.053,0-32.33068,4.33057-32.33068,8.2168s13.2777,8.2168,32.33068,8.2168,32.33069-4.33057,32.33069-8.2168S374.45654,275.90939,355.40356,275.90939Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M426.40344,341.343c-16.64258,0-34.33056-3.58057-34.33056-10.2168s17.688-10.2168,34.33056-10.2168c16.64282,0,34.33081,3.58057,34.33081,10.2168S443.04626,341.343,426.40344,341.343Zm0-18.4336c-19.05286,0-32.33056,4.33057-32.33056,8.2168s13.2777,8.2168,32.33056,8.2168,32.33081-4.33057,32.33081-8.2168S445.45642,322.90939,426.40344,322.90939Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M795.40344,294.343c-16.64258,0-34.33056-3.58057-34.33056-10.2168s17.688-10.2168,34.33056-10.2168c16.64282,0,34.33081,3.58057,34.33081,10.2168S812.04626,294.343,795.40344,294.343Zm0-18.4336c-19.053,0-32.33056,4.33057-32.33056,8.2168s13.27758,8.2168,32.33056,8.2168,32.33081-4.33057,32.33081-8.2168S814.45642,275.90939,795.40344,275.90939Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M724.40344,341.343c-16.64258,0-34.33056-3.58057-34.33056-10.2168s17.688-10.2168,34.33056-10.2168c16.64282,0,34.33081,3.58057,34.33081,10.2168S741.04626,341.343,724.40344,341.343Zm0-18.4336c-19.053,0-32.33056,4.33057-32.33056,8.2168s13.27758,8.2168,32.33056,8.2168,32.33081-4.33057,32.33081-8.2168S743.45642,322.90939,724.40344,322.90939Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><path d="M575.40344,363.343c-16.64258,0-34.33056-3.58057-34.33056-10.2168s17.688-10.2168,34.33056-10.2168c16.64282,0,34.33081,3.58057,34.33081,10.2168S592.04626,363.343,575.40344,363.343Zm0-18.4336c-19.053,0-32.33056,4.33057-32.33056,8.2168s13.27758,8.2168,32.33056,8.2168,32.33081-4.33057,32.33081-8.2168S594.45642,344.90939,575.40344,344.90939Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><circle cx="336.97785" cy="450.70425" r="42.01233" fill="#2f2e41"/><rect x="565.93651" y="563.55388" width="22.86756" height="12.76328" transform="translate(-457.82019 238.05835) rotate(-26.60099)" fill="#2f2e41"/><ellipse cx="563.82041" cy="573.74843" rx="3.98853" ry="10.63605" transform="translate(-489.27546 647.82906) rotate(-56.60122)" fill="#2f2e41"/><rect x="617.67227" y="558.50174" width="12.76328" height="22.86756" transform="translate(-428.72163 791.92555) rotate(-63.39901)" fill="#2f2e41"/><ellipse cx="637.60379" cy="573.74843" rx="10.63605" ry="3.98853" transform="translate(-474.26735 364.92328) rotate(-33.39878)" fill="#2f2e41"/><circle cx="334.03663" cy="440.42779" r="14.35864" fill="#fff"/><ellipse cx="597.86951" cy="515.08401" rx="4.76624" ry="4.8" transform="translate(-452.84172 492.81919) rotate(-45)" fill="var(--app-color)"/><path d="M633.854,485.80233c.63177-15.55359-12.77314-28.7276-29.9408-29.42493s-31.59692,11.346-32.22873,26.8996,11.30191,19.08746,28.46958,19.78485S633.22214,501.35592,633.854,485.80233Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/><ellipse cx="644.38811" cy="537.56776" rx="6.59448" ry="21.00616" transform="translate(-458.4377 468.61755) rotate(-40.64516)" fill="#2f2e41"/><ellipse cx="557.15365" cy="537.56776" rx="21.00616" ry="6.59448" transform="translate(-477.37906 529.35274) rotate(-49.35484)" fill="#2f2e41"/><path d="M612.25083,548.0638a9.57244,9.57244,0,0,1-18.83533,3.42884l-.00336-.0185c-.94177-5.20214,3.08039-7.043,8.28254-7.98474S611.30912,542.86166,612.25083,548.0638Z" transform="translate(-263.73425 -80.80301)" fill="#fff"/><path d="M529.73425,576.197a2.0001,2.0001,0,0,1-2-2v-118a2,2,0,0,1,4,0v118A2.0001,2.0001,0,0,1,529.73425,576.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M499.73425,682.197a2.0001,2.0001,0,0,1-2-2v-86a2,2,0,1,1,4,0v86A2.0001,2.0001,0,0,1,499.73425,682.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M576.73425,611.197a2.0001,2.0001,0,0,1-2-2v-118a2,2,0,1,1,4,0v118A2.0001,2.0001,0,0,1,576.73425,611.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M547.73425,696.197a2.0001,2.0001,0,0,1-2-2v-48a2,2,0,1,1,4,0v48A2.0001,2.0001,0,0,1,547.73425,696.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M588.73425,450.197a2.0001,2.0001,0,0,1-2-2v-48a2,2,0,0,1,4,0v48A2.0001,2.0001,0,0,1,588.73425,450.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M488.73425,471.197a2.0001,2.0001,0,0,1-2-2v-48a2,2,0,0,1,4,0v48A2.0001,2.0001,0,0,1,488.73425,471.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M662.73425,476.197a2.0001,2.0001,0,0,1-2-2v-48a2,2,0,1,1,4,0v48A2.0001,2.0001,0,0,1,662.73425,476.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M658.73425,626.197a2.0001,2.0001,0,0,1-2-2v-58a2,2,0,1,1,4,0v58A2.0001,2.0001,0,0,1,658.73425,626.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M618.73425,677.197a2.0001,2.0001,0,0,1-2-2v-86a2,2,0,1,1,4,0v86A2.0001,2.0001,0,0,1,618.73425,677.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><path d="M626.73425,530.197a2.0001,2.0001,0,0,1-2-2v-118a2,2,0,1,1,4,0v118A2.0001,2.0001,0,0,1,626.73425,530.197Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><ellipse cx="858.10361" cy="764.78333" rx="6.76007" ry="21.53369" transform="translate(-554.53185 648.46489) rotate(-39.93837)" fill="#2f2e41"/><circle cx="812.2965" cy="757.30544" r="43.06733" transform="translate(-426.75153 1207.63346) rotate(-71.56505)" fill="#2f2e41"/><rect x="553.7073" y="710.30199" width="13.08374" height="23.44171" fill="#2f2e41"/><rect x="527.53982" y="710.30199" width="13.08374" height="23.44171" fill="#2f2e41"/><ellipse cx="555.8879" cy="734.01629" rx="10.90314" ry="4.08868" fill="#2f2e41"/><ellipse cx="529.72042" cy="733.47115" rx="10.90314" ry="4.08868" fill="#2f2e41"/><path d="M798.77365,703.16853c3.84557-15.487,20.82057-24.60076,37.91471-20.35617s27.83428,20.24028,23.98871,35.72729-16.60394,15.537-33.69809,11.29233S794.92806,718.65557,798.77365,703.16853Z" transform="translate(-263.73425 -80.80301)" fill="#ccc"/><ellipse cx="763.7883" cy="737.32189" rx="6.76007" ry="21.53369" transform="translate(-493.44249 1030.65892) rotate(-64.62574)" fill="#2f2e41"/><circle cx="542.12366" cy="667.41487" r="14.35864" fill="#fff"/><circle cx="536.22229" cy="662.26808" r="4.78622" fill="var(--app-color)"/><circle cx="542" cy="697.39398" r="6" fill="#fff"/><path d="M935.26575,819.197h-236a1,1,0,0,1,0-2h236a1,1,0,0,1,0,2Z" transform="translate(-263.73425 -80.80301)" fill="var(--app-color)"/></svg>
                </div>
                <div class="text">
                    <span>Burada kimse yok</span>
                    <span>Görünüşe göre nezih ortamımızda kimseden rahatsızlık duymamış ve engelleyecek kadar ileri gitmemişsiniz, buna sevindik!</span>
                </div>
            </div>
        </div>
        <div class="blocked-users-list"></div>
    </div>
</div>

<div class="settings-details-container" data-category="2" data-tab="1" data-group="1">
    <div class="edit-profile">
        <div class="settings-profile-container">
            <div class="banner-container">
                <div class="banner-filter">
                    <div class="settings-profile-content">
                        <div @click="app.settings(2,2,1,'Özelleştir')" class="settings-profile-avatar pp-content">
                            <img src="{{ %profile['avatar'] }}" alt="">
                        </div>
                        <div class="settings-profile-details">
                            <div class="settings-profile-name settings-edit-profile-top-details-user-name">
                                <span>{{ %profile['name'] }}</span>
                                <div class="verified" data-title="Onaylı kullanıcı">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="checkmark-circle-2"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm4.3 7.61l-4.57 6a1 1 0 0 1-.79.39 1 1 0 0 1-.79-.38l-2.44-3.11a1 1 0 0 1 1.58-1.23l1.63 2.08 3.78-5a1 1 0 1 1 1.6 1.22z"></path></g></g></svg>
                                </div>
                            </div>
                            <div class="settings-profile-username settings-edit-profile-top-details-user-username">
                                <span>{{ %profile['username'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="banner edit-profile-mini-profile-banner-area">
                    @if(%profile['banner']['type'] == 'image')
                        @if(%profile['banner']['url'] == '')
                    <div class="banner-content" style="background: {{ %profile['color'] }} !important;"></div>
                    <img src="{{ %profile['banner']['url'] }}" alt="" style="display: none;">
                    <video src="{{ %profile['banner']['url'] }}" style="display: none;" autoplay muted loop></video>
                        @else
                    <div class="banner-content" style="background: {{ %profile['color'] }} !important; display: none;"></div>
                    <img src="{{ %profile['banner']['url'] }}" alt="">
                    <video src="{{ %profile['banner']['url'] }}" style="display: none;" autoplay muted loop></video>
                        @endif
                    @else
                    <div class="banner-content" style="background: {{ %profile['color'] }} !important; display: none;"></div>
                    <img src="{{ %profile['banner']['url'] }}" alt="" style="display: none;">
                    <video src="{{ %profile['banner']['url'] }}" autoplay muted loop></video>
                    @endif
                </div>
            </div>
        </div>
        <div class="container-group">
            <div @click="app.settings(2,2,1,'Özelleştir')" class="big-buttons edit-profile-custom">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="edit"><rect width="24" height="24" opacity="0"/><path d="M19.4 7.34L16.66 4.6A2 2 0 0 0 14 4.53l-9 9a2 2 0 0 0-.57 1.21L4 18.91a1 1 0 0 0 .29.8A1 1 0 0 0 5 20h.09l4.17-.38a2 2 0 0 0 1.21-.57l9-9a1.92 1.92 0 0 0-.07-2.71zM16 10.68L13.32 8l1.95-2L18 8.73z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Özelleştir</span>
                    <span>Profil fotoğrafı, profil afişi ve profil rengini düzenle</span>
                </div>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title" data-required>Görünen adın</div>
                </div>
            </div>
            <div class="container-group-content">
                <label>
                    <input @max_length="64" class="settings-key-2-name settings-inputs settings-profile-inputs settings-2" type="text" placeholder="Adın" value="{{ %profile['name'] }}" data-default-value="{{ %profile['name'] }}">
                </label>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title" data-required>Kullanıcı adı</div>
                    <div class="container-group-description">Diğer kullanıcılar seni kendi gönderilerinde, hikayelerinde ve yorumlarında aşağıda belirttiğin şekilde bahsedecek (Ör. @kullanıcıadın, @kingslayer14 vs..)</div>
                </div>
            </div>
            <div class="container-group-content">
                <label>
                    <input @max_length="16" class="settings-key-2-username settings-inputs settings-profile-inputs settings-2" type="text" placeholder="Kullanıcı adı" value="{{ %profile['username'] }}" data-default-value="{{ %profile['username'] }}">
                </label>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title" data-required>Hakkımda</div>
                    <div class="container-group-description">Profiline göz gezdirenler ve hayranların için kendin hakkında bir kaç bilgi ver (Eğer internet bağlantısı koyacaksan aşağıda özel bölüm var oraya koyabilirsin :3)</div>
                </div>
            </div>
            <div class="container-group-content">
                <label>
                    <textarea @max_length="200" class="settings-key-2-about settings-inputs settings-profile-inputs settings-2" placeholder="Hakkında bir şeyler yaz..." data-default-value="{{ %profile['other']['about'] }}">{{ %profile['other']['about'] }}</textarea>
                </label>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title">İnternet sitesi</div>
                    <div class="container-group-description">Blog sayfan ve işletme sayfan gibi aklına gelebilecek her şeyi koyabilirsin</div>
                </div>
            </div>
            <div class="container-group-content">
                <label>
                    <input @max_length="64" class="settings-key-2-website settings-inputs settings-profile-inputs settings-2" type="text" placeholder="İnternet sitesi" value="{{ %profile['other']['website'] }}" data-default-value="{{ %profile['other']['website'] }}">
                </label>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title">Konum</div>
                    <div class="container-group-description">Buraya yaşadığınız şehiri, hediye göndermek isteyenler için kargo adresinizi veya işletmeyseniz ofis adresinizi yazabilirsiniz</div>
                </div>
            </div>
            <div class="container-group-content">
                <label>
                    <input @max_length="64" class="settings-key-2-location settings-inputs settings-profile-inputs settings-2" type="text" placeholder="Konum" value="{{ %profile['other']['location'] }}" data-default-value="{{ %profile['other']['location'] }}">
                </label>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title">Katılma tarihini gizle</div>
                    <div class="container-group-description">Profil detaylarında gözüken bir bilgidir, insanların ne zaman Glynet'e katıldığını görmesini istemiyorsan açablirsin</div>
                </div>
            </div>
            <div class="container-group-content">
                <label class="switch">
                    <input
                        class="settings-key-2-joined_at settings-inputs settings-profile-inputs settings-2"
                        type="checkbox"

                        @if(%profile['other']['show_joined_date'] == true)
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="slider"></span>
                </label>
            </div>
        </div>
        <div class="container-group" data-no-bottom>
            <div @click="app.settings(3)" class="big-buttons edit-profile-other">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="shield"><rect width="24" height="24" opacity="0"/><path d="M12 21.85a2 2 0 0 1-1-.25l-.3-.17A15.17 15.17 0 0 1 3 8.23v-.14a2 2 0 0 1 1-1.75l7-3.94a2 2 0 0 1 2 0l7 3.94a2 2 0 0 1 1 1.75v.14a15.17 15.17 0 0 1-7.72 13.2l-.3.17a2 2 0 0 1-.98.25z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Gizlilik & Güvenlik</span>
                    <span>İçerik kontrolü, robotlardan kaçma ve diğer ayarlar</span>
                </div>
            </div>
            <div @click="app.settings(5)" class="big-buttons edit-profile-color">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="color-palette"><rect width="24" height="24" opacity="0"/><path d="M19.54 5.08A10.61 10.61 0 0 0 11.91 2a10 10 0 0 0-.05 20 2.58 2.58 0 0 0 2.53-1.89 2.52 2.52 0 0 0-.57-2.28.5.5 0 0 1 .37-.83h1.65A6.15 6.15 0 0 0 22 11.33a8.48 8.48 0 0 0-2.46-6.25zm-12.7 9.66a1.5 1.5 0 1 1 .4-2.08 1.49 1.49 0 0 1-.4 2.08zM8.3 9.25a1.5 1.5 0 1 1-.55-2 1.5 1.5 0 0 1 .55 2zM11 7a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 11 7zm5.75.8a1.5 1.5 0 1 1 .55-2 1.5 1.5 0 0 1-.55 2z"/></g></g></svg>
                </div>
                <div class="texts">
                    <span>Tema</span>
                    <span><i>"Ay güneşten daha güzel"&nbsp;</i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="2" data-tab="2" data-group="1">
    <div class="edit-profile">
        <form style="display: none; opacity: 0;" enctype="multipart/form-data">
            <input type="file" class="profile-avatar-change-input" accept=".jpg, .png, .jpeg, .gif">
            <input type="file" class="profile-banner-change-input" accept=".jpg, .png, .jpeg, .mp4">
        </form>
        <div class="container-group">
            <div class="change-avatar-container">
                <div class="avatar-preview">
                    <img src="{{ %profile['avatar'] }}" alt="">
                </div>
                <div class="avatar-details">
                    <div class="container-group-top">
                        <div class="container-group-left">
                            <div class="container-group-title">Profil fotoğrafı</div>
                            <div class="container-group-description">Yükleyeceğiniz fotoğrafın yatay ve dikey olarak boyutunun eşit olmasına dikkat edin</div>
                        </div>
                        <div class="container-group-right">
                            <div class="premium-perks-container">
                                <div class="premium-perks-icon-container">
                                    <div class="premium-perks">
                                        <div class="premium-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"/><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></g></g></svg>
                                        </div>
                                        <div class="perks-background"></div>
                                    </div>
                                </div>
                                <div class="perks-details">
                                    <div class="p-details-content">
                                        <span>Dans eden fotoğraf</span>
                                        <span>Profil fotoğrafınıza GIF yerleştirmek için Glynet Premium'a yükseltin</span>
                                    </div>
                                    <div class="p-details-background"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="change-content-buttons">
                        <div @click="client.updateContents(1);" class="settings-2-btn settings-change-avatar-button">Avatarı değiştir</div>
                        <div @click="client.updateContents(1, true);" class="settings-2-btn settings-remove-avatar-button">İçeriği kaldır</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-group">
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title">Profil afişi</div>
                    <div class="container-group-description">Önerilen dosya çözünürlüğü 1280x720</div>
                </div>
                <div class="container-group-right">
                    <div class="premium-perks-container">
                        <div class="premium-perks-icon-container">
                            <div class="premium-perks">
                                <div class="premium-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"/><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></g></g></svg>
                                </div>
                                <div class="perks-background"></div>
                            </div>
                        </div>
                        <div class="perks-details">
                            <div class="p-details-content">
                                <span>3-2-1 Motor!</span>
                                <span>Afişinize fotoğraf yerine video koymak ister misiniz? Glynet Premium'u deneyin</span>
                            </div>
                            <div class="p-details-background"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-group-content">
                <div class="change-banner-container">
                    <div class="banner">
                        @if(%profile['banner']['type'] == 'image')
                            @if(%profile['banner']['url'] == '')
                        <div class="banner-content" style="background: {{ %profile['color'] }} !important;"></div>
                        <img src="{{ %profile['banner']['url'] }}" alt="" style="display: none;">
                        <video src="{{ %profile['banner']['url'] }}" style="display: none;" autoplay muted loop></video>
                            @else
                        <div class="banner-content" style="background: {{ %profile['color'] }} !important; display: none;"></div>
                        <img src="{{ %profile['banner']['url'] }}" alt="">
                        <video src="{{ %profile['banner']['url'] }}" style="display: none;" autoplay muted loop></video>
                            @endif
                        @else
                        <div class="banner-content" style="background: {{ %profile['color'] }} !important; display: none"></div>
                        <img src="{{ %profile['banner']['url'] }}" alt="" style="display: none">
                        <video src="{{ %profile['banner']['url'] }}" autoplay muted loop></video>
                        @endif
                    </div>
                    <div class="change-content-buttons">
                        <div @click="client.updateContents(2);" class="settings-2-btn settings-change-banner-content-button">Afişi değiştir</div>
                        <div @click="client.updateContents(2, true);" class="settings-2-btn settings-remove-banner-content-button">İçeriği kaldır</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-group" data-no-bottom>
            <div class="container-group-top">
                <div class="container-group-left">
                    <div class="container-group-title">Profil rengi</div>
                    <div class="container-group-description">Kullanıcılar profilinize iniş yaptığında etraf seçtiğiniz renge bürünecek, ayrıca Glynet'i kullanırken etrafı seçtiğiniz renk ile görürsünüz</div>
                </div>
                <div class="container-group-right">
                    <div class="premium-perks-container">
                        <div class="premium-perks-icon-container">
                            <div class="premium-perks">
                                <div class="premium-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="flash"><rect width="24" height="24" opacity="0"/><path d="M11.11 23a1 1 0 0 1-.34-.06 1 1 0 0 1-.65-1.05l.77-7.09H5a1 1 0 0 1-.83-1.56l7.89-11.8a1 1 0 0 1 1.17-.38 1 1 0 0 1 .65 1l-.77 7.14H19a1 1 0 0 1 .83 1.56l-7.89 11.8a1 1 0 0 1-.83.44z"/></g></g></svg>
                                </div>
                                <div class="perks-background"></div>
                            </div>
                        </div>
                        <div class="perks-details">
                            <div class="p-details-content">
                                <span>Yavruağzı veya Mürdüm rengi?</span>
                                <span>Aradığın renk yok mu? Premium planı ile kendi kişisel zevklerine göre yeni renkler kullanabilirsin</span>
                            </div>
                            <div class="p-details-background"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-group-content">
                <div class="settings-color-box-container">
                    <div class="color-box-left">
                        <div data-title="Şu anki renk" class="settings-color-box-selected" style="--box-color: {{ %profile['color'] }}"></div>
                    </div>
                    <div class="color-box-right">
                        @foreach(%colors as color)
                        <div @click="client.updateColor('{{ %color }}');" class="settings-color-box settings-color-{{ %color }}" style="--box-color: #{{ %color }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="3" data-tab="1" data-group="1">
    <div class="container-group">
        <div @click="app.settings(3,2,1,'Gönderi seçenekleri')" class="big-buttons privacy-and-safety-post-options">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="grid"><rect width="24" height="24" opacity="0"/><path d="M9 3H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/><path d="M19 3h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/><path d="M9 13H5a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2z"/><path d="M19 13h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Gönderi seçenekleri</span>
                <span>Gönderilerime kimler yorum bırakabilir, beğeni sayısını gizleme vs..</span>
            </div>
        </div>
        <div @click="app.settings(3,3,1,'Cihazlar')" class="big-buttons privacy-and-safety-devices">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"/><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Giriş yapılan cihazlar</span>
                <span>Giriş yapmış olduğunuz tüm cihazları inceleyin</span>
            </div>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Profili gizle</div>
                <div class="container-group-description">Profilini stalkerlardan korumak ve yalnızca onayladığın kişilerin görmesini istiyorsan aktif hale getirebilirsin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-hide_profile settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->hide_profile == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Takip ettiklerini gizle</div>
                <div class="container-group-description">Kullanıcılar profiline girdiklerinde senin kimleri takip ettiğini göremezler ancak sende aynı şekilde kimsenin takip ettiklerini göremezsin</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-hide_followings settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->hide_followings == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Sakıncalı içerikleri göster</div>
                <div class="container-group-description">Sakıncalı içerik olarak işaretlenen gönderileri blurlu bir şekilde gösterme</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-hide_nsfw settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->hide_nsfw == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Arama motorlarından gizlen</div>
                <div class="container-group-description">Arama motorları profilini ve gönderilerini takip edemezler</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-hide_search_engines settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->hide_search_engines == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">E-posta adresimi bilen kişiler beni bulmasına izin ver</div>
                <div class="container-group-description">E-posta adresini bilen kişilerin Glynet'te seni bulmasına ve seninle bağlantı kurmasına izin ver</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-find_email settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->find_email == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Telefon numaramı bilen kişiler beni bulmasına izin ver</div>
                <div class="container-group-description">Telefon numaranı bilen kişilerin Glynet'te seni bulmasına ve seninle bağlantı kurmasına izin ver</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-find_number settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->find_number == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Konuma göre önerilerde bulun</div>
                <div class="container-group-description">Keşfet akışınızda konumunuza göre gönderiler listelenir, kapatırsanız uygulamayı kullandığınız dile göre sonuçlar listelenecektir</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-location_suggestions settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->public_location_suggestions == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div @click="app.settings(3,3,1,'Yakın arkadaşlar')" class="big-buttons privacy-and-safety-close-friends">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="people"><rect width="24" height="24" opacity="0"/><path d="M9 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"/><path d="M17 13a3 3 0 1 0-3-3 3 3 0 0 0 3 3z"/><path d="M21 20a1 1 0 0 0 1-1 5 5 0 0 0-8.06-3.95A7 7 0 0 0 2 20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Yakın arkadaşlar</span>
                <span>Yakın arkadaşlara özel gönderiler ve hikayeler paylaşmak için yakın arkadaşlar listeni düzenle</span>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="3" data-tab="3" data-group="1">

    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Giriş yapılan cihazlar</div>
                <div class="container-group-description">Şüpheli bir oturum gözünüze çarpıyorsa tereddüt etmeden tüm cihazlardan oturumu kapatıp yeni bir şifre oluşturun</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="login-activities">
                @foreach(%last_sessions as session)
                <div class="login-activity">
                    <div class="activity-left-side">
                        <div class="icon">
                            <img src="{{ %session['icon'] }}" alt="">
                        </div>
                    </div>
                    <div class="activity-right-side">
                        <div class="text">
                            <div class="title">
                                <span>{{ %session['device'] }}</span>
                                @if(%session['current_session'] == true)
                                <span>Şu anki oturum</span>
                                @endif
                            </div>
                            <div class="description">
                                <span>{{ %session['browser'] }} ‒ {{ %session['location'] }} ‒ {{ %session['date'] }} ‒ {{ %session['ip_address'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<div class="settings-details-container" data-category="3" data-tab="2" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Beğeni sayısını göster</div>
                <div class="container-group-description">Kapattığınızda gönderilerinizi inceleyen kullanıcılar kaç kişinin beğendiği sayısına erişemezler</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-show_like_count settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->show_like_count == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Paylaşmayı devre dışı bırak</div>
                <div class="container-group-description">Aktif hale geldiğinde kullanıcılar DM yoluyla gönderilerinizi başka kullanıcılar ile paylaşamaz, yalnızca bağlantı ile gönderilebilir</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-3-disable_sharing settings-inputs settings-privacy-inputs settings-3"
                    type="checkbox"

                    @if(%privacy['details']->disable_sharing == 'true')
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Yorum seçenekleri</div>
                <div class="container-group-description">Gönderilerinize kimler yorum bırakabilir düzenleyin</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <label class="checkmark-content">
                    <span>Herkes</span>
                    <input
                        id="settings-radio-3-comment_options_everyone"
                        class="settings-key-3-comment_options settings-inputs settings-privacy-inputs settings-3"
                        type="radio"
                        name="comment-options"

                        @if(%privacy['details']->comment_options == 'everyone')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>


                <label class="checkmark-content">
                    <span>Takip edilenler</span>
                    <input
                        id="settings-radio-3-comment_options_only_followings"
                        class="settings-key-3-comment_options settings-inputs settings-privacy-inputs settings-3"
                        type="radio"
                        name="comment-options"

                        @if(%privacy['details']->comment_options == 'only_followings')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Takipleştiklerim</span>
                    <input
                        id="settings-radio-3-comment_options_only_friends"
                        class="settings-key-3-comment_options settings-inputs settings-privacy-inputs settings-3"
                        type="radio"
                        name="comment-options"

                        @if(%privacy['details']->comment_options == 'only_friends')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Gönderide bahsedilenler</span>
                    <input
                        id="settings-radio-3-comment_options_only_mentioned"
                        class="settings-key-3-comment_options settings-inputs settings-privacy-inputs settings-3"
                        type="radio"
                        name="comment-options"

                        @if(%privacy['details']->comment_options == 'only_mentioned')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Kimse</span>
                    <input
                        id="settings-radio-3-comment_options_nobody"
                        class="settings-key-3-comment_options settings-inputs settings-privacy-inputs settings-3"
                        type="radio"
                        name="comment-options"

                        @if(%privacy['details']->comment_options == 'nobody')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="5" data-tab="1" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Tema</div>
                <div class="container-group-description">Işıl ışıl her yer... her neyse zevklerinize önem veriyoruz ve kör olmanızı istemiyoruz</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <label @click="client.setTheme(1)" class="checkmark-content settings-theme-light">
                    <span>Aydınlık</span>
                    <input
                        class="settings-5"
                        name="theme-options"
                        type="radio"

                        @if(%profile['other']['theme'] == '1')
                        data-default-value="true"
                        checked
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label @click="client.setTheme(2)" class="checkmark-content settings-theme-dark">
                    <span>Karanlık</span>
                    <input
                        class="settings-theme-dark settings-5"
                        name="theme-options"
                        type="radio"

                        @if(%profile['other']['theme'] == '2')
                        data-default-value="true"
                        checked
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label @click="client.setTheme(3)" class="checkmark-content settings-theme-device">
                    <span>Cihazıma göre</span>
                    <input
                        class="settings-theme-device settings-5"
                        name="theme-options"
                        type="radio"

                        @if(%profile['other']['theme'] == '3')
                        data-default-value="true"
                        checked
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Yazı boyutu</div>
                <div class="container-group-description">Yazılar çok küçük ya da büyük geliyorsa gözünüzün rahat edeceği şekilde ayarlayın</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <div class="range-slider-container">
                    <input type="range" min="2" max="13" value="9" class="range-slider range-slider-font-size">
                </div>
            </div>
        </div>
    </div>

    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Satır genişliği</div>
                <div class="container-group-description">Satırlar sıkışık gözüküyorsa gözünüzün rahat edeceği şekilde düzenleyin</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <div class="range-slider-container">
                    <input type="range" min="1" max="15" value="7" class="range-slider range-slider-line-height">
                </div>
            </div>
        </div>
    </div>

    <div class="container-group" data-no-bottom>
        <div @click="app.settings(8)" class="big-buttons settings-go-accessibility">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g data-name="Layer 2"><g data-name="eye"><rect width="24" height="24" opacity="0"/><circle cx="12" cy="12" r="1.5"/><path d="M21.87 11.5c-.64-1.11-4.16-6.68-10.14-6.5-5.53.14-8.73 5-9.6 6.5a1 1 0 0 0 0 1c.63 1.09 4 6.5 9.89 6.5h.25c5.53-.14 8.74-5 9.6-6.5a1 1 0 0 0 0-1zm-9.87 4a3.5 3.5 0 1 1 3.5-3.5 3.5 3.5 0 0 1-3.5 3.5z"/></g></g></svg>
            </div>
            <div class="texts">
                <span>Erişilebilirlik</span>
                <span>Aradığınız ayarlar erişilebilirlik kısmında olabilir, göz atmak için tıklayın</span>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="6" data-tab="1" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Dil</div>
                <div class="container-group-description">Bir dil seç</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <label class="checkmark-content">
                    <span>Türkçe</span>
                    <input
                        id="settings-radio-6-lang-tr"
                        class="settings-key-6-language-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="language-settings"

                        @if(%profile['other']['language'] == 'tr')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                    <span class="image">
                        <img src="https://flagpedia.net/data/flags/h24/tr.png" alt="">
                    </span>
                </label>
                <label class="checkmark-content">
                    <span>İngilizce</span>
                    <input
                        id="settings-radio-6-lang-en"
                        class="settings-key-6-language-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="language-settings"

                        @if(%profile['other']['language'] == 'en')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                    <span class="image">
                        <img src="https://flagpedia.net/data/flags/h24/gb.png" alt="">
                    </span>
                </label>
                <label class="checkmark-content">
                    <span>Azerice</span>
                    <input
                        id="settings-radio-6-lang-az"
                        class="settings-key-6-language-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="language-settings"

                        @if(%profile['other']['language'] == 'az')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                    <span class="image">
                        <img src="https://flagpedia.net/data/flags/h24/az.png" alt="">
                    </span>
                </label>
                <label class="checkmark-content">
                    <span>Almanca</span>
                    <input
                        id="settings-radio-6-lang-de"
                        class="settings-key-6-language-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="language-settings"

                        @if(%profile['other']['language'] == 'de')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                    <span class="image">
                        <img src="https://flagpedia.net/data/flags/h24/de.png" alt="">
                    </span>
                </label>
            </div>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Bölge</div>
                <div class="container-group-description">Bir bölge seç</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <label class="checkmark-content">
                    <span>Afrika</span>
                    <input
                        id="settings-radio-6-region-africa"
                        class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="region-options"

                        @if(%profile['other']['region'] == 'africa')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Amerika</span>
                    <input
                        id="settings-radio-6-region-america"
                        class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="region-options"

                        @if(%profile['other']['region'] == 'america')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Asya</span>
                    <input
                        id="settings-radio-6-region-asia"
                        class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="region-options"

                        @if(%profile['other']['region'] == 'asia')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <input id="settings-radio-6-region-asia" class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6" data-default-value="false" type="radio" name="region-options">
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Avrupa</span>
                    <input
                        id="settings-radio-6-region-europe"
                        class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="region-options"

                        @if(%profile['other']['region'] == 'europe')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Okyanusya</span>
                    <input
                        id="settings-radio-6-region-oceania"
                        class="settings-key-6-region-settings settings-inputs settings-language-inputs settings-6"
                        type="radio"
                        name="region-options"

                        @if(%profile['other']['region'] == 'oceania')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="7" data-tab="1" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Tarayıcı bildirimleri</div>
                <div class="container-group-description">Tarayıcınıza bağlı olarak, aktif hale getirdiğinizde işletim sistemi bildirimleri alırsınız</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input class="settings-7 settings-browser-notifications-slider" data-default-value="false" type="checkbox">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Sesli bildirimler</div>
                <div class="container-group-description">Ding dong! Herhangi bir bildirim geldiğinde size haber vermek için zile basacağız</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input class="settings-7 settings-ding-dong-notifications-slider" data-default-value="true" type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Önemli bildirimleri e-posta ile gönder</div>
                <div class="container-group-description">Hesabınızla ilgili yapılmış şüpheli işlemler gibi önemli konular hakkında mail alırsınız</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input
                    class="settings-key-7-email_alerts settings-inputs settings-notifications-inputs settings-7"
                    type="checkbox"

                    @if(%profile['other']['send_notifications'] == true)
                    data-default-value="true"
                    checked="true"
                    @else
                    data-default-value="false"
                    @endif
                >
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<div class="settings-details-container" data-category="8" data-tab="1" data-group="1">
    <div class="container-group">
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Azaltılmış hareket modu</div>
                <div class="container-group-description">Animasyonlar devre dışı bırakılır</div>
            </div>
        </div>
        <div class="container-group-content">
            <label class="switch">
                <input class="settings-8 settings-reduced-motion-mode-slider" data-default-value="false" type="checkbox">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container-group" data-no-bottom>
        <div class="container-group-top">
            <div class="container-group-left">
                <div class="container-group-title">Videoları otomatik oynat</div>
                <div class="container-group-description">Kaydırma esnasında ekranda gözüken tüm videolar otomatik olarak oynatılır</div>
            </div>
        </div>
        <div class="container-group-content">
            <div class="checkmark-container">
                <label class="checkmark-content">
                    <span>Wi-Fi ve hücresel veri</span>
                    <input
                        id="settings-radio-8-wifi_and_mobile_data"
                        class="settings-key-8-connection_options settings-inputs settings-accessibility-inputs settings-8"
                        name="connection-options"
                        type="radio"

                        @if(%profile['other']['data_saving'] == 'wifi_and_mobile_data')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Yalnızca Wi-Fi</span>
                    <input
                        id="settings-radio-8-only_wifi"
                        class="settings-key-8-connection_options settings-inputs settings-accessibility-inputs settings-8"
                        name="connection-options"
                        type="radio"

                        @if(%profile['other']['data_saving'] == 'only_wifi')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
                <label class="checkmark-content">
                    <span>Hiçbir zaman</span>
                    <input
                        id="settings-radio-8-never"
                        class="settings-key-8-connection_options settings-inputs settings-accessibility-inputs settings-8"
                        type="radio"
                        name="connection-options"

                        @if(%profile['other']['data_saving'] == 'never')
                        data-default-value="true"
                        checked="true"
                        @else
                        data-default-value="false"
                        @endif
                    >
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</div>