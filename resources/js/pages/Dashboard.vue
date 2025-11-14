<template>
    <div>
        <h2 style="margin-top:0; margin-bottom:8px; font-size:1.1rem;">Overzicht</h2>
        <p style="font-size:0.9rem; color:var(--text-sub); margin-top:0;">
            Korte samenvatting van je komende werkdagen en meldingen.
        </p>

        <div v-if="upcoming.length === 0" style="font-size:0.9rem; color:var(--text-sub);">
            Geen geplande items gevonden.
        </div>
        <ul v-else style="list-style:none; padding-left:0; margin:0;">
            <li v-for="item in upcoming" :key="item.id" style="padding:8px 0; border-bottom:1px solid var(--bg-soft);">
                <div style="font-size:0.9rem;">{{ item.date }} – {{ item.label }}</div>
                <div style="font-size:0.8rem; color:var(--text-sub);">{{ item.description }}</div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'DashboardPage',
    props: {
        upcoming: {
            type: Array,
            default: () => []
        }
    }
};
</script>
