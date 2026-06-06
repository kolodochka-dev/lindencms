export class Module {
    constructor() {
        this.initialized = false;
    }

    /**
     * Initialize the module
     */
    init() {

    }

    onLoaded() {

    }

    /**
     * Cleanup resources (for SPA/HTMX)
     */
    destroy() {
        this.initialized = false;
        console.log(`♻️ ${this.name} destroyed`);
    }
}