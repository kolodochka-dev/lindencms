import { Module } from './Module.js'

// todo: tab open event for redrawing lines
export class Lines extends Module {
    dotSizes = 20;
    color = 'rgb(204, 208, 215)';
    colorDot = 'rgb(255, 255, 255)';
    removeColor = '#ef4444';
    observer = null;

    onLoaded() {
        this.bind();
        this.bindHtmx();
    }

    bind() {
        this.drawAllLines();

        // const updateLines = () => {
        //     if (window.collectionLines) {
        //         window.collectionLines.forEach(line => {
        //             if (line && line.update) {
        //                 line.update();
        //             }
        //         });
        //     }
        // };
        // window.addEventListener('scroll', updateLines);
        // window.addEventListener('resize', updateLines);
        // document.addEventListener('tabChanged', updateLines);

        window.addEventListener('tabChanged', () => {
            setTimeout(() => {
                this.drawAllLines()
            }, 50);
        });
    }

    bindHtmx() {
        // Обработка события после загрузки контента HTMX
        // document.addEventListener('htmx:afterSwap', (event) => {
        //     // Если это hx-boost навигация или загрузка нового контента
        //     if (event.detail.target !== document.body || event.detail.boosted) {
        //         setTimeout(() => this.drawAllLines(), 100);
        //     }
        // });

        // При загрузке страницы с hx-boost
        document.addEventListener('htmx:load', (event) => {
            setTimeout(() => this.drawAllLines(), 100);
        });
    }

    cleanupLines() {
        document.querySelectorAll('.lines-container').forEach(svg => {
            svg.remove();
        });
        document.querySelectorAll('.line-dot').forEach(dot => {
            dot.remove();
        });

        if (window.collectionLines) {
            window.collectionLines.forEach(line => {
                if (line && line.remove) {
                    line.remove();
                }
            });
            window.collectionLines = [];
        }
    }

    drawAllLines() {
        this.cleanupLines();

        const collections = document.querySelectorAll('.collection');
        const lines = [];

        collections.forEach(collection => {
            const icon = collection.querySelector(`.collection-head-icon[data-collection="${collection.id}"]`);
            if (!icon) return;

            var iconDot = this.newIconDot(icon);

            const svg = this.createSvgContainer(collection);
            let prevDot = iconDot;

            const collectionItems = collection.querySelector(`.collection-items[data-collection="${collection.id}"]`);
            if (!collectionItems) return;

            const items = Array.from(collectionItems.children);

            items.forEach(item => {
                var innerDot = this.newItemInnerDot(item);
                var outerDot = this.newItemOuterDot(item, iconDot, collection.id);

                lines.push(this.drawLine(svg, outerDot, innerDot));
                lines.push(this.drawLine(svg, prevDot, outerDot));

                prevDot = outerDot;
            });
        });

        window.collectionLines = lines;
    }

    newIconDot(icon) {
        icon.style.position = 'relative';
        const iconDot = document.createElement('div');
        iconDot.className = 'line-dot';
        const left = parseInt(icon.offsetWidth) / 2 - this.dotSizes / 2;

        iconDot.style.cssText = `
            position:absolute;
            bottom:-40%;
            left: ${left}px;
            width:${this.dotSizes}px;
            height:${this.dotSizes}px;
            border-radius: 50%;
        `;
        icon.appendChild(iconDot);

        return iconDot;
    }

    newItemInnerDot(item) {
        if (window.getComputedStyle(item).position === 'static') {
            item.style.position = 'relative';
        }
        const itemDot = document.createElement('div');
        itemDot.className = 'line-dot line-dot-inner';
        itemDot.style.cssText = `
            position:absolute;
            top:${parseInt(item.offsetHeight) / 2 - this.dotSizes / 2}px;
            left:-${this.dotSizes / 2}px;
            width:${this.dotSizes}px;
            height:${this.dotSizes}px;
            border-radius: 50%;
            z-index:-999;
        `;
        item.appendChild(itemDot);

        return itemDot;
    }

    newItemOuterDot(item, iconDot, id) {
        if (window.getComputedStyle(item).position === 'static') {
            item.style.position = 'relative';
        }
        const itemDot = document.createElement('div');
        itemDot.className = 'line-dot line-dot-outer';

        const rectIcon = iconDot.getBoundingClientRect();
        const rectItem = item.getBoundingClientRect();
        const offsetX = parseFloat(rectItem.x) - parseFloat(rectIcon.x);

        itemDot.style.cssText = `
            position: absolute;
            left: -${offsetX}px;
            top: ${parseInt(item.offsetHeight) / 2 - this.dotSizes / 2}px;
            width: ${this.dotSizes}px;
            height: ${this.dotSizes}px;
            background: ${this.colorDot};
            border: 1px solid ${this.removeColor};
            border-radius: 10%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
            z-index: 10;
        `;

        const icon = document.createElement('iconify-icon');
        icon.setAttribute('icon', 'mdi:close');
        icon.setAttribute('width', Math.floor(this.dotSizes * 0.6) + 'px');
        icon.setAttribute('height', Math.floor(this.dotSizes * 0.6) + 'px');
        icon.setAttribute('id', id + "__");
        icon.style.color = this.removeColor;

        itemDot.appendChild(icon);
        itemDot.addEventListener('mouseenter', () => {
            itemDot.style.background = this.removeColor;
            itemDot.style.borderColor = this.removeColor;
            icon.style.color = 'white';
        });
        itemDot.addEventListener('mouseleave', () => {
            itemDot.style.background = this.colorDot;
            itemDot.style.borderColor = this.removeColor;
            icon.style.color = this.removeColor;
        });

        itemDot.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            itemDot.closest('.collection-item').remove();
            this.drawAllLines();
        });

        item.appendChild(itemDot);

        return itemDot;
    }

    createSvgContainer(collection) {
        var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('class', 'lines-container');
        svg.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: visible;
            z-index: 1;
        `;
        collection.style.position = 'relative';
        collection.prepend(svg);

        return svg;
    }

    drawLine(svg, startDot, endDot, isDashed = false) {
        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
        line.setAttribute('class', 'collection-line');

        const updatePosition = () => {
            const collection = svg.closest('.collection');
            if (!collection) return;

            const startRect = startDot.getBoundingClientRect();
            const endRect = endDot.getBoundingClientRect();
            const collectionRect = collection.getBoundingClientRect();

            const x1 = startRect.left - collectionRect.left + startRect.width / 2;
            const y1 = startRect.top - collectionRect.top + startRect.height / 2;
            const x2 = endRect.left - collectionRect.left + endRect.width / 2;
            const y2 = endRect.top - collectionRect.top + endRect.height / 2;

            line.setAttribute('x1', x1);
            line.setAttribute('y1', y1);
            line.setAttribute('x2', x2);
            line.setAttribute('y2', y2);
            line.setAttribute('stroke', this.color);
            line.setAttribute('stroke-width', '1');

            if (isDashed) {
                line.setAttribute('stroke-dasharray', '2,2');
            }
        };

        updatePosition();
        svg.appendChild(line);

        return {
            element: line,
            update: updatePosition,
            remove: () => {
                if (line.parentNode) {
                    line.parentNode.removeChild(line);
                }
            }
        };
    }
}