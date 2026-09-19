import type { ScreenshotStep } from '@verbb/craft-screenshots/types';

/** Isolate the real Consume clients table in a compact, presentation-neutral frame. */
export function createConsumeClientsFrameStep(): ScreenshotStep {
    return {
        type: 'evaluate',
        expression: `
            (() => {
                document.getElementById('consume-clients-screenshot-frame')?.remove();

                const content = document.querySelector('#content');
                if (!(content instanceof HTMLElement)) {
                    throw new Error('Consume client content was not found.');
                }

                const frame = document.createElement('div');
                frame.id = 'consume-clients-screenshot-frame';
                frame.style.cssText = [
                    'position:fixed',
                    'left:0',
                    'top:0',
                    'width:980px',
                    'box-sizing:border-box',
                    'padding:28px',
                    'background:#e4edf6',
                    'z-index:2147483646',
                ].join(';');

                const panel = document.createElement('div');
                panel.style.cssText = [
                    'overflow:hidden',
                    'border:1px solid #c8d3df',
                    'border-radius:8px',
                    'background:#f3f7fb',
                    'box-shadow:0 14px 35px rgba(31, 47, 67, 0.12)',
                ].join(';');

                content.style.width = '100%';
                content.style.maxWidth = 'none';
                content.style.height = 'auto';
                content.style.minHeight = '0';
                content.style.margin = '0';
                content.style.padding = '24px';
                content.style.boxSizing = 'border-box';

                const tableRoot = content.querySelector('#clients-vue-admin-table');
                if (tableRoot instanceof HTMLElement) {
                    tableRoot.style.height = 'auto';
                    tableRoot.style.minHeight = '0';
                }

                panel.append(content);
                frame.appendChild(panel);
                document.body.appendChild(frame);
                document.documentElement.style.background = '#e4edf6';
                document.body.style.margin = '0';
                document.body.style.overflow = 'hidden';
            })();
        `,
    };
}
