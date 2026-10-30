import { Module } from './Module.js'

export class SelectMulti extends Module {
    onLoaded() {
        this.bind();
        this.bindHtmx();
    }

    bind() {
        document.querySelectorAll('[data-select]').forEach((root) => {
            const list = root.querySelector('[data-select-list]');
            const pills = root.querySelector('[data-select-pills]');

            if (!list) return;

            list.querySelectorAll('[data-select-list-name]').forEach((input) => {
                input.addEventListener('change', (e) => this.onSelect(e));
            });

            if (pills) {
                pills.addEventListener('click', (e) => this.onPillRemove(e));
            }
        });
    }

    bindHtmx() {
        document.addEventListener('htmx:load', () => this.bind());
    }

    createPill(name, value, label) {
        const pill = document.createElement('div');
        pill.className = 'selectSource_selected_item';
        pill.textContent = label;
        pill.dataset.value = value;

        const remove = document.createElement('span');
        remove.dataset.selectPillRemove = '';
        remove.innerHTML = '<iconify-icon icon="ant-design:close-outlined" width="13" height="13"></iconify-icon>';

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = name;
        hidden.value = value;

        pill.append(remove, hidden);

        return pill;
    }

    onSelect(e) {
        const input = e.target;
        const root = input.closest('[data-select]');
        if (!root) return;

        const pills = root.querySelector('[data-select-pills]');
        if (!pills) return;

        const mode = input.dataset.selectMode; // 'single' | 'multi'
        const name = input.dataset.selectListName;
        const label = input.dataset.selectListLabel;
        const value = input.value;

        if (mode === 'single') {
            pills.replaceChildren(
                input.checked ? this.createPill(name, value, label) : ''
            );
            return;
        }

        if (input.checked) {
            if (pills.querySelector(`[data-value="${CSS.escape(value)}"]`)) return;
            pills.appendChild(this.createPill(name, value, label));
        } else {
            pills.querySelector(`[data-value="${CSS.escape(value)}"]`)?.remove();
        }
    }

    onPillRemove(e) {
        const remove = e.target.closest('[data-select-pill-remove]');
        if (!remove) return;

        const pill = remove.closest('[data-value]');
        if (!pill) return;

        const root = pill.closest('[data-select]');
        const value = pill.dataset.value;

        pill.remove();

        root?.querySelectorAll('[data-select-list-name]').forEach((input) => {
            if (input.value === value) input.checked = false;
        });
    }
}