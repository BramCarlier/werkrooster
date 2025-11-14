import { createApp } from 'vue';
import Dashboard from './pages/Dashboard.vue';
import SchedulePage from './pages/SchedulePage.vue';
import SettingsPage from './pages/SettingsPage.vue';
import SchedulerStatus from './pages/SchedulerStatus.vue';

// Dashboard
const dashboardEl = document.getElementById('dashboard-root');
if (dashboardEl) {
    const upcoming = JSON.parse(dashboardEl.dataset.upcoming || '[]');
    createApp(Dashboard, { upcoming }).mount(dashboardEl);
}

// Rooster
const scheduleEl = document.getElementById('schedule-root');
if (scheduleEl) {
    const schedule = JSON.parse(scheduleEl.dataset.schedule || '[]');
    createApp(SchedulePage, { initialSchedule: schedule }).mount(scheduleEl);
}

// Instellingen
const settingsEl = document.getElementById('settings-root');
if (settingsEl) {
    const initialSettings = JSON.parse(settingsEl.dataset.settings || '{}');
    const slackTestUrl = settingsEl.dataset.slackTestUrl;
    const smsTestUrl = settingsEl.dataset.smsTestUrl;

    createApp(SettingsPage, {
        initialSettings,
        slackTestUrl,
        smsTestUrl,
    }).mount(settingsEl);
}

// Scheduler status
const schedulerEl = document.getElementById('scheduler-root');
if (schedulerEl) {
    const logs = JSON.parse(schedulerEl.dataset.logs || '[]');
    const lastSuccess = JSON.parse(schedulerEl.dataset.lastSuccess || 'null');
    const lastError = JSON.parse(schedulerEl.dataset.lastError || 'null');

    createApp(SchedulerStatus, {
        logs,
        lastSuccess,
        lastError,
    }).mount(schedulerEl);
}
