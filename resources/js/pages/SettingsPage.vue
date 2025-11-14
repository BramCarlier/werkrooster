<template>
    <div class="page">
        <header class="page-header">
            <h2>Instellingen</h2>
            <p>Configureer Slack, SMS en algemene notificatie-instellingen.</p>
        </header>

        <div class="card-inner">
            <!-- Slack -->
            <section class="section">
                <div class="section-header">
                    <h3>Slack</h3>
                    <p>Stel je Slack incoming webhook URL in voor meldingen.</p>
                </div>
                <div class="section-body">
                    <div class="field">
                        <label class="field-label" for="slack_webhook_url">Incoming webhook URL</label>
                        <input
                            id="slack_webhook_url"
                            v-model="form.slack_webhook_url"
                            type="text"
                            class="input"
                            placeholder="https://hooks.slack.com/services/..."
                        />
                    </div>
                    <div class="actions">
                        <button type="button" class="btn btn-primary" @click="save">Opslaan</button>
                        <button type="button" class="btn btn-secondary" @click="testSlack">Test Slack</button>
                    </div>
                </div>
            </section>

            <!-- SMS -->
            <section class="section">
                <div class="section-header">
                    <h3>SMS</h3>
                    <p>Voer het GSM-nummer in dat notificaties moet ontvangen.</p>
                </div>
                <div class="section-body">
                    <div class="field">
                        <label class="field-label" for="sms_to">GSM-nummer (ontvanger)</label>
                        <input
                            id="sms_to"
                            v-model="form.sms_to"
                            type="text"
                            class="input"
                            placeholder="+324..."
                        />
                    </div>
                    <div class="actions">
                        <button type="button" class="btn btn-secondary" @click="testSms">Test SMS</button>
                    </div>
                    <p class="hint">
                        Twilio-credentials stel je in via <code>TWILIO_SID</code>, <code>TWILIO_TOKEN</code>,
                        <code>TWILIO_FROM</code> in je <code>.env</code> bestand.
                    </p>
                </div>
            </section>

            <!-- Notificatievoorkeuren -->
            <section class="section">
                <div class="section-header">
                    <h3>Notificatievoorkeuren</h3>
                    <p>Beheer de dagelijkse samenvatting via Slack/SMS.</p>
                </div>
                <div class="section-body">
                    <div class="field field-inline">
                        <label class="checkbox-label">
                            <input
                                type="checkbox"
                                v-model="form.enable_daily_summary"
                                class="checkbox"
                            />
                            <span>Dagelijkse ochtend-samenvatting via Slack/SMS</span>
                        </label>
                    </div>
                    <div class="field field-small">
                        <label class="field-label" for="daily_time">Tijd (HH:MM)</label>
                        <input
                            id="daily_time"
                            v-model="form.daily_time"
                            type="time"
                            class="input"
                        />
                    </div>
                    <div class="actions">
                        <button type="button" class="btn btn-secondary" @click="save">Opslaan</button>
                        <span v-if="message" class="saved-label">{{ message }}</span>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'SettingsPage',
    props: {
        initialSettings: {
            type: Object,
            default: () => ({})
        },
        slackTestUrl: String,
        smsTestUrl: String
    },
    data() {
        return {
            form: {
                slack_webhook_url: this.initialSettings.slack_webhook_url || '',
                sms_to: this.initialSettings.sms_to || '',
                enable_daily_summary: this.initialSettings.enable_daily_summary || false,
                daily_time: this.initialSettings.daily_time || '07:00'
            },
            message: ''
        };
    },
    methods: {
        async save() {
            this.message = '';
            await axios.post('/settings', this.form);
            this.message = 'Instellingen opgeslagen';
            setTimeout(() => (this.message = ''), 2000);
        },
        async testSlack() {
            this.message = '';
            await axios.post(this.slackTestUrl);
            this.message = 'Slack-test verstuurd (controleer je kanaal).';
            setTimeout(() => (this.message = ''), 2000);
        },
        async testSms() {
            this.message = '';
            await axios.post(this.smsTestUrl);
            this.message = 'SMS-test verstuurd (indien Twilio correct is geconfigureerd).';
            setTimeout(() => (this.message = ''), 2000);
        }
    }
};
</script>

<style scoped>
.page {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.page-header h2 {
    margin: 0 0 4px;
    font-size: 1.15rem;
}

.page-header p {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-sub);
}

.card-inner {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.section {
    padding: 10px 0;
    border-bottom: 1px solid var(--bg-soft);
}

.section:last-of-type {
    border-bottom: none;
}

.section-header h3 {
    margin: 0 0 4px;
    font-size: 0.98rem;
}

.section-header p {
    margin: 0;
    font-size: 0.8rem;
    color: var(--text-sub);
}

.section-body {
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.field-label {
    font-size: 0.8rem;
    color: var(--text-sub);
}

.field-small {
    max-width: 200px;
}

.field-inline {
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
}

.checkbox-label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
}

.checkbox {
    width: 16px;
    height: 16px;
}

.input {
    display: block;
    width: 100%;
    padding: 6px 8px;
    border-radius: 10px;
    border: 1px solid var(--bg-soft);
    font-size: 0.8rem;
    background: var(--bg-card);
    color: var(--text);
    box-sizing: border-box;
}

.input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 1px rgba(14, 165, 233, 0.3);
}

.actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}

.btn {
    border-radius: 999px;
    border: none;
    padding: 6px 14px;
    font-size: 0.85rem;
    cursor: pointer;
}

.btn-primary {
    background: var(--primary);
    color: #fff;
}

.btn-secondary {
    background: var(--bg-soft);
    color: var(--text-sub);
}

.saved-label {
    font-size: 0.8rem;
    color: var(--text-sub);
}

.hint {
    margin: 0;
    font-size: 0.75rem;
    color: var(--text-sub);
}

@media (max-width: 640px) {
    .field-inline {
        flex-direction: row;
        align-items: center;
    }
}
</style>
