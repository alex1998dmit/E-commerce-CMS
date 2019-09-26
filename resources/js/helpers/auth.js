export function isAdmin(user) {
    if (user.role.filter(role => role.name == 'operator' || role.name == 'admin').length > 0) {
        return true;
    }
    return false;
}
