package customermodel

type Customer struct {
	Name string
	Sex  string
	Old  int
	Phone string
	Email string 
}

func  NewCustomer(name string,sex string ,old int, phone string,email string) Customer {
	var customer =Customer{
		Name:  name,
		Sex:   sex,
		Old:   old,
		Phone: phone,
		Email: email,
	}
	return customer
}

