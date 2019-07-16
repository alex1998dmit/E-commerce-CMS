export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if (!user) {
        return null;
    }

    return JSON.parse(userStr);
}
