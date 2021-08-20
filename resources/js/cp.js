import Settings from './components/settings'

Statamic.booting(() => {
    Statamic.$components.register('settings', Settings);
});
