import httpService from "../services/httpService";

export default {
    getLocale(defaultLocale = 'geo') {
        const locale = localStorage.getItem('locale')
        if (locale) {
            return locale;
        }
        return defaultLocale;
    }
}
