import { Module } from './Module.js'

export class Setlist extends Module {
    rootClass = 'setlist';

    onLoaded() {
        // this.bind();
        this.bindHtmx();
    }

    bind() {
        this.update();
    }

    bindHtmx() {
        // hx-boost
        document.addEventListener('htmx:load', (event) => {
            setTimeout(() => this.update(), 100);
        });
    }

    update() {
        document.querySelectorAll(`.${this.rootClass}`).forEach(root => {
            this.updatePills(root);

            const options = root.querySelector('.options');
            let checkboxes = options.querySelectorAll('input[type="checkbox"]');
            if (checkboxes.length === 0) {
                checkboxes = options.querySelectorAll('input[type="radio"]')
            }

            let isAnyChecked = false;
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.updatePills(root);
                });
                isAnyChecked = true;
            });

            if (isAnyChecked) {
                options.querySelector('.not-found').style.display = isAnyChecked
                    ? 'none'
                    : 'block';
            }

            // Simple SEARCH
            root?.querySelector('.search')?.addEventListener('input', (e) => {
                const searchText = e.target.value.toLowerCase();
                checkboxes.forEach(checkbox => {
                    const label = checkbox.closest('label');
                    const isVisible = label.textContent.toLowerCase().includes(searchText);
                    label.style.display = isVisible ? 'flex' : 'none';
                });
            })
        });
    }

    clearPills(container) {
        container.querySelectorAll('.pill').forEach(pill => pill.remove());
    }

    updatePills(root) {
        const pillContainer = root.querySelector('.container');
        this.clearPills(pillContainer)

        const updatePill = (checkbox) => {
            const pillTempl = checkbox.closest('label').querySelector('.pill-templ');

            // PILL
            const pill = document.createElement('div');
            pill.className = 'pill';
            pill.innerHTML = pillTempl.innerHTML;

            // REMOVE PILL BUTTON
            const removePill = document.createElement('span')
            removePill.className = 'remove-pill'
            removePill.innerHTML = `<iconify-icon icon="mdi:window-close" class="" width="15" height="15"></iconify-icon>`;
            removePill.addEventListener('click', () => {
                checkbox.checked = false;
                this.updatePills(root);
            })

            pill.appendChild(removePill);
            pillContainer.appendChild(pill);
        }

        const updateNotFoundLabel = (isAnyChecked) => {
            pillContainer.querySelector('.not-found').style.display = isAnyChecked
                ? 'none'
                : 'block';
        }

        // Checkboxes or radios
        let checkboxes = root.querySelectorAll('.options input[type="checkbox"]');
        if (checkboxes.length === 0) {
            checkboxes = root.querySelectorAll('.options input[type="radio"]')
        }

        var checked = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                updatePill(checkbox)
                checked.push(checkbox);
            }
        });
        updateNotFoundLabel(checked.length > 0)
    }
}
