Vagrant.configure(2) do |config|
    config.vm.box = "ubuntu/trusty64"

    config.vm.provision :shell, path: "vagrant/provision.sh"

    config.vm.network "private_network", ip: "192.168.7.7"

    config.vm.synced_folder ".", "/vagrant"

    config.vm.provider "virtualbox" do |v|
        v.memory = 1024
        v.cpus = 1
    end
end
