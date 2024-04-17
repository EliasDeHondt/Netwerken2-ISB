# 💙🤍Documentation🤍💙

## 📘Table of Contents

1. [📘Table of Contents](#📘table-of-contents)
2. [🖖Introduction](#🖖introduction)
3. [💩Group members](#💩group-members)
4. [🎨Network Design](#🎨network-design)
    1. [🎨Globel Design](#🎨globel-design)
    2. [🎨WAN Design](#🎨wan-design)
    3. [🎨DMZ Design](#🎨dmz-design)
    4. [🎨LAN Design](#🎨lan-design)
5. [🔎Addressing/names](#🔎addressingnames)
6. [🚬VPN Services](#🚬vpn-services)
    1. [🚬VPN Settings For A Client](#🚬vpn-settings-for-a-client)
    2. [🚬Server Settings](#🚬server-settings)
    3. [🚬VPN Test](#🚬vpn-test)
7. [🛡️Firewall Rules](#🛡️firewall-rules)
8. [🪖DMZ Services](#🪖dmz-services)
9. [🧮Testing](#🧮testing)
10. [🚀X Factor](#🚀x-factor)
11. [📁Attachments](#📁attachments)
    1. [📁Router Configurations](#📁router-configurations)
    2. [📁Firewall Configurations](#📁firewall-configurations)
    3. [📁Server Configurations & Scripts](#📁server-configurations--scripts)
    4. [📁Timesheets](#📁timesheets)
12. [🔗References](#🔗references)

---

## 🖖Introduction

This is the documentation for the project of the course `Network 2 - ISB` at the `KDG`. The goal of this project is to create a network with a DMZ, LAN, WAN, VPN, and a firewall. The network should be able to handle high availability, load balancing, and stress tests...

## 💩Group members

- Student 1: Elias De Hondt 0160712-80
- Student 2: Kobe Wijnants 0163403-55

## 🎨Network Design

### 🎨Globel Design
![Globel Design](/images/globel_design.png)

### 🎨WAN Design
![WAN Design](/images/wan_design.png)

### 🎨DMZ Design
![DMZ Design](/images/dmz_design.png)

### 🎨LAN Design
![LAN Design](/images/lan_design.png)

## 🔎Addressing/names

### 🔎Globel
| Name            | IP Address                  | Interface |
|-----------------|-----------------------------|-----------|
| Router 1        | 10.10.1.1, 255.255.255.254  | Gig0/0    |
| Router 2        | 10.10.1.5, 255.255.255.254  | Gig0/0    |
| Router 1        | 10.10.4.1, 255.255.255.0    | Gig1/0    |
| Router 2        | 10.10.4.2, 255.255.255.0    | Gig1/0    |

### 🔎LAN
| Name            | IP Address                  | Interface |
|-----------------|-----------------------------|-----------|
| Server 3 (DNS)  | 10.10.3.10, 255.255.255.0   | Fa0       |
| Server 4 (DHCP) | 10.10.3.11, 255.255.255.0   | Fa0       |
| Router 3        | 10.10.3.1, 255.255.255.0    | Gig2/0    |
| Router 3        | 10.10.1.2, 255.255.255.254  | Gig0/0    |
| Router 3        | 10.10.1.6, 255.255.255.254  | Gig1/0    |
| Switch 3        | 10.10.3.2, 255.255.255.0    | Lo0       |

### 🔎DMZ
| Name            | IP Address                  | Interface |
|-----------------|-----------------------------|-----------|
| Server 1 (Web)  | 10.10.4.10, 255.255.255.0   | Gig0      |
| Server 1 (Web)  | 10.10.4.11, 255.255.255.0   | Gig1      |
| Server 2 (Web)  | 10.10.4.12, 255.255.255.0   | Gig0      |
| Server 2 (Web)  | 10.10.4.13, 255.255.255.0   | Gig1      |

## 🚬VPN Services

As a VPN solution we will use tailscale, this is a zero-config VPN based on wireguard.

Tailscale utilizes WireGuard's encryption and authentication mechanisms to establish secure peer-to-peer connections between devices. It assigns each device a unique tailnet IP and has dashboard for easy maintainability.

### 🚬VPN Settings For A Client

#### 🚬Linux

- Open the terminal and run:

```bash
sudo curl -fsSL https://tailscale.com/install.sh | sh
```

- Enter the root password and run the following command

```bash
sudo tailscale up
```
- Copy and Paste the link in your browser and login

- Click Connect and you should be connected to the tailnet

#### 🚬Windows

- Download the following msi installer

[Tailscale Download](https://tailscale.com/download)

- Run the installer

- Click Next and Install

- Then login and you should be connected to the tailnet

### 🚬VPN Settings For A Server
- Open the terminal and run:

```bash
sudo curl -fsSL https://tailscale.com/install.sh | sh
```

- Enter the root password

- Request an auth key at: [Tailscale Login](https://login.tailscale.com/admin/settings/keys)

- Use the auth key in the following command and add `--ssh` so you can use tailscale ssh
```bash
sudo tailscale up --authkey=[Authkey] --ssh
```

- The server should now be connected to the tailnet

### 🚬VPN Settings For A Router

Wij zullen pfsense gebruiken als router software, hierop heb je een package manager met de package "tailscaled"

### 🚬VPN Test
> Een VPN-client moet minimum via de VPN server aan bv een DMZ server.
> Schrijf de testprocedure hiervoor uit. Welke aanpassingen moest je maken aan de routetabel of aan de encryptie?

## 🛡️Firewall Rules
> Firewall voor je LAN
> Schrijf alle regels die gelden tussen de LAN en de DMZ/Internet in woorden uit.
> Firewall voor Internet (denk ook aan VPN)
> Schrijf alle regels die gelden tussen Internet en de DMZ/LAN in woorden uit.

## 🪖DMZ Services
- This will all be achieved with apache2 and a simple database a .csv file. A webpage will be hosted on multiple web servers. On this webpage, you can modify a value that will change the background color of the webpage. This new value will be stored in a file or database. Subsequently, the other web servers will be automatically updated with the new background.

- Database
    - [CSV File](/Scripts/database.csv)
- Apache2 Webserver 1
    - [Index File](/Scripts/index1.php)
    - [Apache2 Config](/Scripts/redundant-web-servers-demo.conf)
- Apache2 Webserver 2
    - [Index File](/Scripts/index2.php)
    - [Apache2 Config](/Scripts/redundant-web-servers-demo.conf)
- Apache2 Load Balancer
    - [Apache2 Config](/Scripts/redundant-web-servers-demo.conf)

- Everything will be hosted on one Ubuntu server 20.04 LTS 64-bit with apache2 for the demo. See the [Network Design](#🎨network-design) for the real physical setup.

```bash
# Basic setup:
sudo apt update && sudo apt upgrade -y
sudo do-release-upgrade -d # Optional - upgrade to latest Ubuntu LTS
sudo apt install openssh-server -y
sudo apt install apache2 -y
sudo apt install php libapache2-mod-php -y
sudo apt install git -y
sudo a2enmod proxy proxy_http
sudo a2enmod lbmethod_byrequests

# Firewall Configuratie:
sudo ufw allow 22
sudo ufw allow 80
sudo ufw allow 8001
sudo ufw allow 8002
sudo ufw enable # Or sudo ufw disable

# Configure static IP for the server:
sudo nano /etc/netplan/00-installer-config.yaml
# Add the following:
network:
  version: 2
  renderer: networkd
  ethernets:
    ens33:
      dhcp4: no
      addresses: [192.168.70.133/24]
      gateway4: [192.168.70.1/24]
      nameservers:
        addresses: [8.8.8.8, 8.8.4.4]

sudo netplan apply

# Configure Webserver 1 & 2 + Load Balancer:
sudo rm -r /var/www/html
sudo rm -r /etc/apache2/sites-available/000-default.conf
sudo rm -r /etc/apache2/sites-available/default-ssl.conf
sudo rm -r /etc/apache2/sites-enabled/000-default.conf
git clone https://github.com/EliasDeHondt/Netwerken2-ISB.git
sudo mkdir /var/www/webserver1
sudo mkdir /var/www/webserver2
sudo cp Netwerken2-ISB/Scripts/index1.php /var/www/webserver1/
sudo cp Netwerken2-ISB/Scripts/index2.php /var/www/webserver2/
sudo cp Netwerken2-ISB/Scripts/redundant-web-servers-demo.conf.conf /etc/apache2/sites-available/
sudo a2ensite redundant-web-servers-demo.conf

# Database setup:
sudo cp Netwerken2-ISB/Scripts/database.csv /var/www/
sudo chmod 755 /var/www/database.csv

# Clean up:
sudo systemctl reload apache2
sudo rm -r Netwerken2-ISB
history -c # Clear history
```

## 🧮Testing
> Omschrijf de procedure en toon het resultaat van high availability/load balancing/stress testen van je server diensten.

## 🚀X Factor
- For our X Factor, we chose to do a price calculation of how expensive the network would be. We will calculate the price of the hardware and software we used in the network. So we provide a price for the routers, switches, servers, and software. And for the fun, we did it in a script.

```bash
#!/bin/bash

# Define hardware prices
declare -A hardware_prices=(
    [Router1]=1000
    [Router2]=1000
    [Router3]=1000
    [Switch1]=500
    [Switch2]=500
    [Switch3]=500
    [Server1]=2000
    [Server2]=2000
    [Server3]=2000
    [Server4]=2000
)

# Define software prices
declare -A software_prices=(
    [Pfsense]=0
    [Vyos]=0
    [Ubuntu]=0
    [Apache2]=0
    [Tailscale]=0
)

# Function to calculate total price
calculate_total_price() {
    local total=0
    for item in "${!hardware_prices[@]}" "${!software_prices[@]}"; do
        price=$(get_price "$item")
        if [[ -n $price ]]; then
            total=$((total + price))
        else
            echo "Price for $item not found." >&2
        fi
    done
    echo "$total"
}

# Function to get price for a particular item
get_price() {
    local item=$1
    local price

    if [[ -v hardware_prices[$item] ]]; then
        price=${hardware_prices[$item]}
    elif [[ -v software_prices[$item] ]]; then
        price=${software_prices[$item]}
    else
        return 1
    fi

    echo "$price"
}

# Function to print total price
print_total_price() {
    local total=$(calculate_total_price)
    echo "The total price of the network is $total"
}

# Main program
main() {
    print_total_price
}

# Execute main program
main
```

## 📁Attachments

### 📁Router Configurations

### 📁Firewall Configurations

### 📁Server Configurations & Scripts
[Scripts Folder](/Scripts)

### 📁Timesheets
| Name Student  | Date       | Time  | Description           |
|---------------|------------|-------|-----------------------|
| Elias De Hondt| 15/04/2024 | 2h    | Documentation         |
| Kobe Wijnants | 15/04/2024 | 2h    | Documentation         |
| Elias De Hondt| 15/04/2024 | 3h    | Network Design        |
| Kobe Wijnants | 15/04/2024 | 30min | Addressing/names      |
| Elias De Hondt| 15/04/2024 | 5h    | Redundant Web Servers |

### 📁DO TO
- [] Documentation
- [x] Network Design
- [x] Addressing/names
- [] Firewall Rules
- [x] Redundant Web Servers
- [] Redundant Router
- [] VPN Services
- [x] X-Factor

## 🔗References
- [Tailscale](https://tailscale.com)
- [Wireguard](https://www.wireguard.com)
- [Pfsense](https://www.pfsense.org)
- [Vyos](https://www.vyos.io)
- [Apache2](https://httpd.apache.org)
- [Ubuntu](https://ubuntu.com)