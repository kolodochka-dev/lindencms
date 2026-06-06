import { Module } from './Module.js'

export class Tabs extends Module {
    onLoaded() {
        this.bind();
    }

    bind() {
        this.initTabs();

        // Обработка события после загрузки контента HTMX
        document.addEventListener('htmx:afterSwap', (event) => {
            // Если это hx-boost навигация или загрузка нового контента
            if (event.detail.target !== document.body || event.detail.boosted) {
                setTimeout(() => this.initTabs(), 100);
            }
        });

        // Обработка навигации с hx-boost
        document.addEventListener('htmx:beforeHistoryUpdate', () => {
            this.initTabs();
        });

        // При загрузке страницы с hx-boost
        document.addEventListener('htmx:load', (event) => {
            if (event.detail.boosted) {
                setTimeout(() => this.initTabs(), 100);
            }
        });

        document.body.addEventListener('htmx:historyRestore', () => this.initTabs());
    }

    initTabs() {
        const containers = document.querySelectorAll('[data-tab-container]');
        containers.forEach((container) => {
            const btns = container.querySelector('[data-tab-buttons]');
            Array.from(btns.children).forEach((btn) => {
                btn.addEventListener('click', (e) => this.openTab(e))
            });
        });
    }

    openTab(e) {
        const target = e.currentTarget;
        const activeTab = document.getElementById(target.dataset.tabTarget);
        if (!activeTab) {
            return;
        }

        // const container = target.closest('[data-tab-container]');

        // Set active button
        const btns = target.closest('[data-tab-buttons]');
        Array.from(btns.children).forEach((btn) => {
            btn.classList.remove(btn.dataset.tabActive);
        });
        target.classList.add(target.dataset.tabActive);

        // Set active content
        const contents = activeTab.closest('[data-tab-contents]');
        Array.from(contents.children).forEach((content) => {
            content.classList.remove(content.dataset.tabActive);
        });
        activeTab.classList.add(activeTab.dataset.tabActive);

        this.fireTabChangedEvent(activeTab, target);
    }

    // openTab(evt, targetId, contextElement = document) {
    //     const target = document.getElementById(targetId);
    //     if (!target) {
    //         console.log(`Element #${targetId} not found!`)
    //     }

    //     // Set active button
    //     const btns = evt.currentTarget.closest('.tab-buttons');
    //     btns.children().forEach((btn) => {
    //         btn.classList.remove("active");
    //     });
    //     evt.currentTarget.classList.add("active");

    //     // Set active content
    //     const contents = target.closest('.tab-contents');
    //     contents.children().forEach((content) => {
    //         content.classList.remove("active");
    //     });
    //     target.classList.add("active");

    //     this.fireTabChangedEZvent(target, target);
    // }

    fireTabChangedEvent(activeTab) {
        const tabChangedEvent = new CustomEvent('tabChanged', {
            detail: {
                tabId: activeTab.get,
                timestamp: new Date().toISOString()
            },
            bubbles: true,
            cancelable: true
        });

        activeTab.dispatchEvent(tabChangedEvent);
    }
}