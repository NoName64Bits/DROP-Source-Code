#Restore normal configs
cp /etc/config/unspoof/firewall /etc/config/
cp /etc/config/unspoof/dhcp /etc/config/

#Restart the run level
/etc/init.d/firewall restart
/etc/init.d/dnsmasq restart
