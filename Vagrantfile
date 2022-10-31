
Vagrant.configure("2") do |config|
  # Virtual OS
  config.vm.box = "almalinux/8"

  # PrivateIP
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.network :forwarded_port, guest: 8000, host: 8000
  config.vm.network :forwarded_port, guest: 8080, host: 8080
  config.vm.network :forwarded_port, guest: 8081, host: 8081
  config.vm.network :forwarded_port, guest: 80, host: 80
  config.vm.network :forwarded_port, guest: 443, host: 443

  # Synced Folder
  config.vm.synced_folder ".", "/vagrant", disabled: true
  config.vm.synced_folder "./", "/vagrant", type:"virtualbox", mount_options: ['dmode=777','fmode=777']
  config.vm.synced_folder "./contents", "/vagrant_contents", type:"virtualbox", mount_options: ['dmode=777','fmode=777']

  # Provisioning Script
  config.vm.provision :shell, :path => "provision.sh"

  config.vm.provider "virtualbox" do |vm|
    # メモリを1024MBに設定
    vm.memory = 1024
  end

end
