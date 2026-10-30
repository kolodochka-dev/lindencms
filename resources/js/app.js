import '../css/app.css';

import 'iconify-icon';
import { app } from './AppManager.js';
import { Tabs } from './modules/Tabs.js';
import { Lines } from './modules/Lines.js';
import { SelectMulti } from './modules/SelectMulti.js';

app.registerModule('Tabs', Tabs);
app.registerModule('Lines', Lines);
app.registerModule('SelectMulti', SelectMulti);
app.init();