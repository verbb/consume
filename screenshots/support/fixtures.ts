import { readFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

import type { ScreenshotSetupContext } from '@verbb/craft-screenshots/types';

const supportDir = dirname(fileURLToPath(import.meta.url));
const seedScript = readFileSync(join(supportDir, 'seed', 'seed-clients.php'), 'utf8');

/** Seed representative credential and OAuth clients for the client index. */
export async function seedConsumeClients(context: ScreenshotSetupContext): Promise<void> {
    await context.runCraftScript(seedScript, { label: 'seed-consume-clients' });
}
