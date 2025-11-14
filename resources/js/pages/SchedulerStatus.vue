<template>
    <div>
        <h2 style="margin-top:0; margin-bottom:8px; font-size:1.1rem;">Scheduler status</h2>
        <p style="font-size:0.9rem; color:var(--text-sub); margin-top:0;">
            Overzicht van de recente <code>schedule:run</code>-uitvoeringen (via Forge cron).
        </p>

        <div style="margin-bottom:12px;">
            <div v-if="lastSuccess" style="font-size:0.9rem;">
                Laatste succesvolle run:
                <strong>{{ formatDate(lastSuccess.ran_at) }}</strong>
            </div>
            <div v-else style="font-size:0.9rem; color:var(--text-sub);">
                Nog geen succesvolle runs geregistreerd.
            </div>

            <div v-if="lastError" style="font-size:0.85rem; color:var(--danger); margin-top:4px;">
                <strong>Laatste fout:</strong> {{ formatDate(lastError.ran_at) }} – {{ lastError.error }}
            </div>
        </div>

        <table style="width:100%; border-collapse:collapse; font-size:0.85rem; margin-top:8px;">
            <thead>
            <tr>
                <th style="text-align:left; padding:6px 4px;">Datum/tijd</th>
                <th style="text-align:left; padding:6px 4px;">Duur (s)</th>
                <th style="text-align:left; padding:6px 4px;">Status</th>
                <th style="text-align:left; padding:6px 4px;">Fout</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="log in logs" :key="log.id" style="border-top:1px solid var(--bg-soft);">
                <td style="padding:6px 4px;">{{ formatDate(log.ran_at) }}</td>
                <td style="padding:6px 4px;">{{ (log.duration ?? 0).toFixed(2) }}</td>
                <td style="padding:6px 4px;">
          <span :style="{ color: log.success ? '#16a34a' : '#dc2626' }">
            {{ log.success ? 'OK' : 'FOUT' }}
          </span>
                </td>
                <td style="padding:6px 4px; max-width:260px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ log.error || '-' }}
                </td>
            </tr>
            <tr v-if="logs.length === 0">
                <td colspan="4" style="padding:8px 4px; font-size:0.85rem; color:var(--text-sub);">
                    Nog geen scheduler-runs gelogd.
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'SchedulerStatus',
    props: {
        logs: {
            type: Array,
            default: () => []
        },
        lastSuccess: {
            type: Object,
            default: null
        },
        lastError: {
            type: Object,
            default: null
        }
    },
    methods: {
        formatDate(value) {
            if (!value) return '';
            // Laravel geeft meestal een ISO string
            return new Date(value).toLocaleString();
        }
    }
};
</script>
