// resources/js/AppManager.js
class AppManager {
    constructor() {
        this.modules = new Map();
        this.initialized = false;
    }

    /**
     * Register a module
     * @param {string} name - Module name
     * @param {BaseModule} moduleClass - Module class
     */
    registerModule(name, moduleClass) {
        if (this.modules.has(name)) {
            console.warn(`Module "${name}" already registered`);
            return;
        }

        const instance = new moduleClass();
        this.modules.set(name, instance);

        // instance.init();
        console.log(`📦 Module "${name}" registered`);
    }

    /**
     * Initialize all registered modules
     */
    init() {
        if (this.initialized) return;

        this.modules.forEach((module, name) => {
            if (!module.initialized) {
                module.init();
                module.initialized = true;
                // add to global window to use in templates
                window[name] = module;
                document.addEventListener('DOMContentLoaded', () => module.onLoaded());
                console.log(`🚀 Module ${name} is initialized`);
            }
        });

        this.initialized = true;
        console.log('🚀 All modules initialized');
    }

    /**
     * Get module instance
     */
    getModule(name) {
        return this.modules.get(name);
    }

    /**
     * Initialize specific module
     */
    initModule(name) {
        const module = this.modules.get(name);
        if (module && !module.initialized) {
            module.init();
        }
    }

    /**
     * Destroy all modules
     */
    destroy() {
        this.modules.forEach(module => {
            if (module.destroy) {
                module.destroy();
            }
        });
        this.initialized = false;
    }
}

// Singleton instance
export const app = new AppManager();