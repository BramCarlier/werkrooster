<template>
    <div>
        <h2 style="margin-top:0; margin-bottom:8px; font-size:1.1rem;">Instellingen</h2>
        <p style="font-size:0.9rem; color:var(--text-sub); margin-top:0;">
            Configureer Slack, SMS en algemene notificatie-instellingen.
        </p>

        <section style="margin-bottom:16px;">
            <h3 style="font-size:0.95rem; margin-bottom:6px;">Slack</h3>
            <label style="font-size:0.8rem;">
                Incoming webhook URL
                <input v-model="form.slack_webhook_url" type="text" />
            </label>
            <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
                <button type="button" class="btn-primary" @click="save">Opslaan</button>
                <button type="button" class="btn-secondary" @click="testSlack">Test Slack</button>
                <span v-if="message" style="font-size:0.8rem; color:var(--text-sub);">{{ message }}</span>
            </div>
        </section>

        <section style="margin-bottom:16px;">
            <h3 style="font-size:0.95rem; margin-bottom:6px;">SMS</h3>
            <label style="font-size:0.8rem;">
                GSM-nummer (ontvanger)
                <input v-model="form.sms_to" type="text" placeholder="+324..." />
            </label>
            <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
                <button type="button" class="btn-secondary" @click="testSms">Test SMS</button>
            </div>
            <p style="font-size:0.75rem; color:var(--text-sub);">
                Twilio-credentials zelf instellen in .env (TWILIO_SID, TWILIO_TOKEN, TWILIO_FROM).
            </p>
        </section>

        <section>
            <h3 style="font-size:0.95rem; margin-bottom:6px;">Notificatievoorkeuren</h3>
            <label style="display:flex; align-items:center; gap:6px; font-size:0.8rem;">
                <input type="checkbox" v-model="form.enable_daily_summary" />
                Dagelijkse ochtend-samenvatting via Slack/SMS
            </label>
            <label style="font-size:0.8rem; margin-top:6px;">
                Tijd (HH:MM)
                <input v-model="form.daily_time" type="time" />
            </label>
            <div style="margin-top:8px;">
                <button type="button" class="btn-secondary" @click="save">Opslaan</button>
            </div>
        </section>
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
            setTimeout(() => (this.message = ''), 1500);
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
input {
    padding: 4px 6px;
    border-radius: 8px;
    border: 1px solid var(--bg-soft);
    font-size: 0.8rem;
    width: 100%;
}
.btn-primary {
    border-radius: 999px;
    border: none;
    padding: 6px 12px;
    font-size: 0.85rem;
    cursor: pointer;
    background: var(--primary);
    color: #fff;
}
.btn-secondary {
    border-radius: 999px;
    border: none;
    padding: 6px 12px;
    font-size: 0.85rem;
    cursor: pointer;
    background: var(--bg-soft);
    color: var(--text-sub);
}
</style>
