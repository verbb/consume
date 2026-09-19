import { defineScreenshotScenario } from '@verbb/craft-screenshots/api';

import { seedConsumeClients } from '../../support/fixtures';
import { createConsumeClientsFrameStep } from '../../support/presets';

export default defineScreenshotScenario({
    id: 'consume-feature-tour-clients',
    output: 'feature-tour/clients.png',
    route: '/admin/consume/clients',
    viewport: {
        width: 1100,
        height: 700,
        deviceScaleFactor: 2,
    },
    async setup(context) {
        await seedConsumeClients(context);
    },
    waitFor: [
        { type: 'loadState', state: 'networkidle' },
        { type: 'selector', selector: '#clients-vue-admin-table table tbody tr', state: 'attached' },
    ],
    preSteps: [createConsumeClientsFrameStep()],
    target: {
        type: 'selector',
        selector: '#consume-clients-screenshot-frame',
        padding: 0,
    },
    caption: 'Configured credential and OAuth clients with their connection status and providers.',
    intent: 'Shows Consume’s central client index using deterministic, realistically configured integrations.',
});
