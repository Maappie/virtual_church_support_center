# Virtual Church Assistant (VCA)
### Centralized Web Platform for Administrative Workflow Digitalization (May 2024)

The **Virtual Church Assistant (VCA)** is a complete web platform designed for the National Shrine of Saint Michael and the Archangels to modernize its administrative operations. By digitizing traditional paper-based service requests (e.g., baptism, masses, appointments), the VCA centralizes data management and streamlines the approval process, significantly improving efficiency and visitor service.

---

## 🚀 Key Features

- **Digitized Service Requests:** Allows parishioners and visitors to submit various service requests directly through the web platform.
- **Administrative Dashboard:** A central control panel that provides staff with a consolidated view of all pending, approved, and completed requests.
- **Workflow Automation:** Implements logic to automate stages of the request approval and notification process, reducing manual labor.
- **Data Centralization:** All request information and historical data are stored in a unified MySQL database for easy reporting and retrieval.
- **Responsive Interface:** Front-end is optimized using HTML/CSS/JavaScript to ensure seamless access and usability across desktop and mobile devices.

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Environment:** XAMPP Stack 

---

## ⚙️ System Architecture

The VCA utilizes a traditional three-tier architecture:

1.  **Presentation Tier:** Built with HTML, CSS, and JavaScript, handling all user interaction and rendering a responsive interface for both visitors and administrators.
2.  **Logic Tier:** PHP scripts process incoming service requests, perform validation, execute workflow automation logic, and handle user authentication.
3.  **Data Tier:** MySQL manages the structured storage of all user profiles, service request data, and administrative logs, ensuring data integrity and quick retrieval. 

[Image of Three-Tier Web Application Architecture Diagram]


---

## 💻 Setup and Installation

This project is built on the standard XAMPP stack.

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/yourusername/virtual-church-assistant.git](https://github.com/yourusername/virtual-church-assistant.git)
    ```

2.  **Environment Setup**
    * Install a local server environment ( **XAMPP** ).
    * Place the project files into your server's root directory (`htdocs`).

3.  **Database Configuration**
    * Create a new MySQL database named `church`.
    * Import the provided database schema file (`church.sql`) into the newly created database.
    * Update the database connection parameters (username, password, database name) in the main configuration file (`config.php` or similar) to match your local environment.

4.  **Access the Platform**
    * Open your browser and navigate to `http://localhost/virtual-church-assistant`.

---

## 📝 License
This project is open-source and available under the [MIT License](LICENSE).
