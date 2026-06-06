import '../css/app.css';

import 'quill/dist/quill.snow.css'; 
import 'iconify-icon';
import { app } from './AppManager.js';
import { Tabs } from './modules/Tabs.js';
import { Forms } from './modules/Forms.js';
import { Lines } from './modules/Lines.js';
import { Setlist } from './modules/Setlist.js';
import { Tables } from './modules/Tables.js';
import { QuillEditor } from './modules/QuillEditor.js';

app.registerModule('Tabs', Tabs);
app.registerModule('Forms', Forms);
app.registerModule('Lines', Lines);
app.registerModule('Setlist', Setlist);
app.registerModule('Tables', Tables);
app.registerModule('QuillEditor', QuillEditor);
app.init();