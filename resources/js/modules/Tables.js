import { Module } from './Module.js'

export class Tables extends Module {
    onLoaded() {
        this.bind();
        this.bindHtmx();
    }

    bind() {
        document.querySelectorAll('.nodes-table').forEach(table => {
            table.addEventListener('click', this.handleTableClick);
            table.addEventListener('change', this.handleCheckboxChange);
        });
    }
    
    handleTableClick = (event) => {
        // Находим строку, на которой произошел клик
        const tr = event.target.closest('tr');
        if (!tr) return;
        
        // Проверяем, не кликнули ли на интерактивный элемент
        if (event.target.closest('button, a, .btn, input')) {
            return;
        }
        
        const checkbox = tr.querySelector('input[type="checkbox"][name="ids[]"]');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    bindHtmx() {
        // hx-boost
        document.addEventListener('htmx:load', (event) => {
            setTimeout(() => this.bind(), 100);
        });
    }
}