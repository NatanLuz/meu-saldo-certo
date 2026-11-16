# Store Management System | ShoppingCenter

## 📖 About the Project

The **Store Management System - ShoppingCenter** is a console-based Java application that represents and manages the stores and products of a shopping center.

The project was developed to apply fundamental concepts of Object-Oriented Programming and system modeling. The solution organizes the domain into classes, subclasses, and associations, providing hands-on practice with encapsulation, inheritance, polymorphism, and method overriding.

Data is kept in arrays while the program runs. The application has no persistence and uses an interactive menu to register, query, and manipulate information.

### Modeling

The main classes represent the elements shared across the domain:

- `Loja` (Store);
- `Produto` (Product);
- `Endereco` (Address);
- `Data` (Date).

The `Loja` class is specialized into the following subclasses:

- `Cosmetico` (Cosmetics);
- `Vestuario` (Clothing);
- `Bijuteria` (Jewelry);
- `Alimentacao` (Food);
- `Informatica` (Computing).

### OOP Concepts

- **Encapsulation:** private attributes accessed through getters and setters;
- **Inheritance:** specialization of the `Loja` class;
- **Polymorphism:** specific behavior in the subclasses;
- **Association:** relationships between store, address, date, and products;
- **Overriding:** redefinition of methods such as `toString()`;
- **Class organization:** separation of the domain's responsibilities.

## ✨ Features

- Store registration;
- product registration;
- store listing;
- product listing;
- adding products to a store's inventory;
- product removal;
- expired product check through date comparison;
- store count by category;
- identification of the computing store with the highest insurance value;
- management through an interactive console menu.

### System Rules

- Each store has an associated address and founding date;
- products are managed within the stores;
- expiration is verified by comparing dates;
- the computing store with the highest insurance is identified by comparing values;
- data remains in memory during execution.

## 🚀 Technologies

- **Java:** application implementation;
- **Object-Oriented Programming:** domain modeling and organization;
- **Git:** version control;
- **GitHub:** repository hosting.

## ⚙️ How to Run

### Prerequisites

- Java Development Kit installed;
- Git;
- a compatible Java IDE.

### Clone the repository

```bash
git clone https://github.com/NatanLuz/DesafioLAB1JAVA.git
cd DesafioLAB1JAVA
```

### Import into an IDE

Import the cloned folder as a Java project in one of the following IDEs:

- IntelliJ IDEA;
- Eclipse;
- NetBeans.

### Start the application

Locate and run the class:

```text
src/Principal.java
```

Once it starts, use the menu displayed in the console to register stores, manage products, and query information.

## 📂 Project Structure

The source code lives in the `src/` directory, with the main classes, the store subclasses, and the entry point:

```text
.
├── src/
│   ├── Loja.java
│   ├── Produto.java
│   ├── Endereco.java
│   ├── Data.java
│   ├── subclasses/
│   └── Principal.java
```

- `Loja.java`: base class for stores;
- `Produto.java`: product representation;
- `Endereco.java`: address data;
- `Data.java`: date representation and comparison;
- `subclasses/`: specializations of `Loja`;
- `Principal.java`: entry point and interactive menu.

## 👤 Author

**Natan Da Luz**

- LinkedIn: [linkedin.com/in/natandaluz](https://www.linkedin.com/in/natandaluz/)

- Portfolio: [portfolionatan.vercel.app](https://portfolionatan.vercel.app/)

- Email: [natandaluz01@gmail.com](mailto:natandaluz01@gmail.com)
