#Restore spoof configs
cp /etc/config/spoof/firewall /etc/config/
cp /etc/config/spoof/dhcp /etc/config/

#Restart the run level
/etc/init.d/firewall restart
/etc/init.d/dnsmasq restart


