# WAKULIMA PORTAL UI

### ** FARMER MODULE **

### **1. Personal Details**

| **Field Name**  | **Data Type** | **Validation/Rules**                                  | **Description**                |
| --------------- | ------------- | ----------------------------------------------------- | ------------------------------ |
| `first_name`    | `String`      | Required, max length: 255                             | First name of the farmer.      |
| `last_name`     | `String`      | Required, max length: 255                             | Last name of the farmer.       |
| `email`         | `String`      | Required, valid email format, unique                  | Contact email address.         |
| `phone_number`  | `String`      | Required, valid phone number, unique                  | Contact phone number.          |
| `date_of_birth` | `Date`        | Required, valid date format                           | Farmer's date of birth.        |
| `gender`        | `String`      | Required, enum: ['Male', 'Female', 'Other']           | Gender of the user.            |
| `photo`         | `String`      | Optional, valid image file (JPEG, PNG), max size: 5MB | Profile picture of the farmer. |

---

### **2. Security**

| **Field Name**     | **Data Type** | **Validation/Rules**                                                                                           | **Description**                      |
| ------------------ | ------------- | -------------------------------------------------------------------------------------------------------------- | ------------------------------------ |
| `password`         | `String`      | Required, minimum length: 8, must contain at least one uppercase letter, one number, and one special character | User's account password.             |
| `confirm_password` | `String`      | Required, must match the `password` field                                                                      | Confirmation of the user's password. |

---

### **3. Address**

| **Field Name**    | **Data Type** | **Validation/Rules**                          | **Description**                  |
| ----------------- | ------------- | --------------------------------------------- | -------------------------------- |
| `country`         | `String`      | Required, max length: 100                     | Country of residence.            |
| `state`           | `String`      | Required, max length: 100                     | State or region of residence.    |
| `city`            | `String`      | Required, max length: 100                     | City of residence.               |
| `postal_code`     | `String`      | Required, max length: 20, numeric             | Postal or ZIP code.              |
| `street_address`  | `String`      | Required, max length: 255                     | Full street address.             |
| `geo_coordinates` | `String`      | Optional, valid latitude and longitude format | Geographic location of the farm. |

---

### **4. Other Information**

| Field Name                 | Data Type     | Validation/Rules                                                      | Description                                      |
| -------------------------- | ------------- | --------------------------------------------------------------------- | ------------------------------------------------ |
| years_of_experience        | Integer       | Optional, positive integer                                            | Number of years farming.                         |
| education_level            | String        | Optional, enum: ['None', 'Primary', 'Secondary', 'Tertiary', 'Other'] | Farmer's highest level of education.             |
| membership_in_cooperatives | Boolean       | Optional                                                              | Whether the farmer is a member of a cooperative. |
| certifications             | Array[String] | Optional, each string max length: 100                                 | Farming-related certifications held.             |

---

### **5. Notification**

| **Field Name**           | **Data Type** | **Validation/Rules**                           | **Description**                          |
| ------------------------ | ------------- | ---------------------------------------------- | ---------------------------------------- |
| `email_notifications`    | `Boolean`     | Optional, default: true                        | Enables or disables email notifications. |
| `sms_notifications`      | `Boolean`     | Optional, default: false                       | Enables or disables SMS notifications.   |
| `notification_frequency` | `String`      | Optional, enum: ['Daily', 'Weekly', 'Monthly'] | Frequency of notifications.              |

---

### **6. Subscription Plan**

| **Field Name**   | **Data Type** | **Validation/Rules**                               | **Description**                       |
| ---------------- | ------------- | -------------------------------------------------- | ------------------------------------- |
| `plan_name`      | `String`      | Required, enum: ['Basic', 'Premium', 'Enterprise'] | Name of the subscription plan.        |
| `start_date`     | `Date`        | Required                                           | Start date of the subscription.       |
| `end_date`       | `Date`        | Required                                           | End date of the subscription.         |
| `payment_status` | `String`      | Required, enum: ['Paid', 'Pending', 'Failed']      | Status of the subscription payment.   |
| `renewal_status` | `Boolean`     | Optional, default: false                           | Indicates if auto-renewal is enabled. |
