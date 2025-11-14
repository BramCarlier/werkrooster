<template>
    <div class="page">
        <header class="page-header">
            <h2>Rooster</h2>
            <p>Stel je vaste werkdagen, uren en subtaken in.</p>
        </header>

        <div class="card-inner">
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Dag</th>
                        <th>Start</th>
                        <th>Einde</th>
                        <th>Subtaken</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in localSchedule" :key="row.day">
                        <td class="cell-label">{{ row.day }}</td>
                        <td class="cell-input">
                            <input v-model="row.start" type="time" class="input" />
                        </td>
                        <td class="cell-input">
                            <input v-model="row.end" type="time" class="input" />
                        </td>
                        <td class="cell-input">
                            <input
                                v-model="row.subtasks"
                                type="text"
                                class="input input-subtasks"
                                placeholder="bv. Studio 08:45–09:00; ..."
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="actions">
                <button type="button" @click="save" class="btn btn-primary">
                    Opslaan
                </button>
                <span v-if="saved" class="saved-label">Opgeslagen!</span>
            </div>
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
    gap: 12px;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 0.9rem;
}

.table thead tr {
    background: var(--bg-soft);
}

.table th,
.table td {
    padding: 8px 6px;
    text-align: left;
    vertical-align: middle;
}

.table tbody tr:nth-child(even) {
    background: rgba(148, 163, 184, 0.08);
}

.cell-label {
    font-weight: 500;
    white-space: nowrap;
}

.cell-input {
    min-width: 90px;
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

.input-subtasks {
    min-width: 220px;
}

.actions {
    display: flex;
    align-items: center;
    gap: 10px;
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

.saved-label {
    font-size: 0.8rem;
    color: var(--text-sub);
}

@media (max-width: 640px) {
    .table th:nth-child(4),
    .table td:nth-child(4) {
        min-width: 200px;
    }
}
</style>
