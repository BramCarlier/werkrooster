<template>
    <div>
        <h2 style="margin-top:0; margin-bottom:8px; font-size:1.1rem;">Rooster</h2>
        <p style="font-size:0.9rem; color:var(--text-sub); margin-top:0;">
            Stel je vaste werkdagen, uren en subtaken in.
        </p>

        <table style="width:100%; border-collapse:collapse; font-size:0.9rem; margin-top:8px;">
            <thead>
            <tr>
                <th style="text-align:left; padding:6px 4px;">Dag</th>
                <th style="text-align:left; padding:6px 4px;">Start</th>
                <th style="text-align:left; padding:6px 4px;">Einde</th>
                <th style="text-align:left; padding:6px 4px;">Subtaken</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in localSchedule" :key="row.day">
                <td style="padding:6px 4px;">{{ row.day }}</td>
                <td style="padding:6px 4px;"><input v-model="row.start" type="time" /></td>
                <td style="padding:6px 4px;"><input v-model="row.end" type="time" /></td>
                <td style="padding:6px 4px;"><input v-model="row.subtasks" type="text" style="width:100%;" /></td>
            </tr>
            </tbody>
        </table>

        <div style="margin-top:12px; display:flex; gap:8px;">
            <button type="button" @click="save" class="btn-primary">Opslaan</button>
            <span v-if="saved" style="font-size:0.8rem; color:var(--text-sub);">Opgeslagen!</span>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'SchedulePage',
    props: {
        initialSchedule: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            localSchedule: JSON.parse(JSON.stringify(this.initialSchedule || [])),
            saved: false
        };
    },
    methods: {
        async save() {
            this.saved = false;
            await axios.post('/schedule', {
                schedule: this.localSchedule
            });
            this.saved = true;
            setTimeout(() => (this.saved = false), 1500);
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
</style>
