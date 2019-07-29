export function isAdmin(user) {
    if (user.role.filter(role => role.name == 'operator' || role.name == 'admin').length > 0) {
        console.log(true);
        return true;
    }
    console.log(false);
    return false;
}
