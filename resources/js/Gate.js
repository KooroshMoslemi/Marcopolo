export default class Gate{
    constructor(role_name){
        this.role_name = role_name;
    }

    isDeveloper(){
        return this.role_name === 'Developer';
    }
    isAdmin(){
        return this.role_name === 'Admin';
    }
    isSalesPerson(){
        return this.role_name === 'SalesPerson';
    }
    isAuthor(){
        return this.role_name === 'Author';
    }
    isAdminORDeveloper(){
        if(this.role_name === 'Admin' || this.role_name === 'Developer')
        {
            return true;
        }
        return false;
    }

}