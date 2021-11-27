namespace Glynet
{
    export class Stories
    {
        getStories(): void
        {
            let stories_area = $('.stories');

            _({
                url: 'api/@me/stories/collect',
                method: 'GET'
            }, (r: object) => {
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

                storyData['stories'].forEach((story: object) => {
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
}