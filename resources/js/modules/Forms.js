import { Module } from './Module.js'

export class Forms extends Module {
    onLoaded() {
        // this.bind();
        this.bindHtmx();
        this.initDroplists();
    }

    bind() {
        this.updateRelations();
    }

    bindHtmx() {
        // hx-boost
        document.addEventListener('htmx:load', (event) => {
            setTimeout(() => this.updateRelations(), 100);
        });
    }

    initDroplists() {
        document.addEventListener('click', (e) => {
            // If clicking on show button
            if (e.target.closest('.droplist-show')) {
                this.hideAllDroplists();
                const droplistSelect = e.target.closest('.droplist')?.querySelector('.droplist-select');
                if (droplistSelect) {
                    droplistSelect.classList.toggle('shown');
                }
                return;
            }

            // If clicking outside any droplist
            const clickedInsideDroplist = e.target.closest('.droplist');
            if (!clickedInsideDroplist) {
                this.hideAllDroplists();
            }
        });
    }

    hideAllDroplists() {
        document.querySelectorAll('.droplist-select.shown').forEach((select) => {
            select.classList.remove('shown');
        });
    }

    updateRelations() {
        document.querySelectorAll('.relations').forEach(relation => {
            this.updateRelationsPills(relation);

            let checkboxes = relation.querySelectorAll('.relations-options input[type="checkbox"]');
            if (checkboxes.length === 0) {
                checkboxes = relation.querySelectorAll('.relations-options input[type="radio"]')
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.updateRelationsPills(relation);
                });
            });

            // SEARCH
            relation?.querySelector('.relations-search')?.addEventListener('input', (e) => {
                const searchText = e.target.value.toLowerCase();
                checkboxes.forEach(checkbox => {
                    const label = checkbox.closest('label');
                    const isVisible = label.textContent.toLowerCase().includes(searchText);
                    label.style.display = isVisible ? 'flex' : 'none';
                });
            })
        });
    }

    clearRelationsPills(container) {
        container.querySelectorAll('.relations-pill').forEach((pill) => pill.remove());
    }

    updateRelationsPills(relation) {
        const pillContainer = relation.querySelector('.relations-selected');
        this.clearRelationsPills(pillContainer)

        const updateRelationsPill = (checkbox) => {
            const label = checkbox.closest('label').textContent.trim();

            // PILL 
            const pill = document.createElement('div');
            pill.className = 'relations-pill';
            pill.innerHTML = (checkbox.dataset.link)
                ? `<span class="relations-pill-link" onclick="window.open('${checkbox.dataset.link}', '_blank')">${label}</span>`
                : label;

            // REMOVE PILL BUTTON
            const removePill = document.createElement('span')
            removePill.className = 'relations-remove_pill'
            removePill.innerHTML = `<iconify-icon icon="mdi:window-close" class="" width="15" height="15"></iconify-icon>`;
            removePill.addEventListener('click', () => {
                checkbox.checked = false;
                this.updateRelationsPills(relation);
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
        let checkboxes = relation.querySelectorAll('.relations-options input[type="checkbox"]');
        if (checkboxes.length === 0) {
            checkboxes = relation.querySelectorAll('.relations-options input[type="radio"]')
        }

        var checked = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                updateRelationsPill(checkbox)
                checked.push(checkbox);
            }
        });
        updateNotFoundLabel(checked.length > 0)
    }
}
