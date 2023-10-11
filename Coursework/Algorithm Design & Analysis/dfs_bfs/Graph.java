// jdh CS224 Spring 2023

import java.util.List;
import java.util.ArrayList;
import java.util.Stack;
import java.util.Queue;
import java.util.LinkedList;

public class Graph {
    List<Node> nodes;

    //------------------------------------------------

    public Graph() {
        nodes = new ArrayList<Node>();
    }

    //------------------------------------------------

    public void addNode(Node node) {
        for (Node n: this.nodes) {
            if (n == node) {
                System.out.println("ERROR: graph already has a node " + n.name);
                assert false;
            }
        }
        this.nodes.add(node);
    }

    //------------------------------------------------

    public void addEdge(Node n1, Node n2) {
        // outgoing edge
        int idx1 = this.nodes.indexOf(n1);
        if (idx1 < 0) {
            System.out.println("ERROR: node " + n1.name + " not found in graph");
            assert false;
        }

        int idx2 = this.nodes.indexOf(n2);
        if (idx2 < 0) {
            System.out.println("ERROR: node " + n2.name + " not found in graph");
            assert false;
        }

        n1.addEdge(n2);
    }

    //------------------------------------------------

    public List<Node> DFS(Node s) {
        // implement this
        List<Node> explored = new ArrayList<Node>();
        Stack<Node> stack = new Stack<Node>();
        stack.push(s);
        while (!stack.isEmpty()) {
            Node u = stack.pop();
            if (!explored.contains(u)) {
                explored.add(u);
                for (Node v : u.adjlist) {
                    stack.push(v);
                }
            }
        }
        return explored;

    } // DFS()

    //------------------------------------------------
    public List<Node> BFS(Node s) {
        List<Node> discovered = new ArrayList<Node>();
        Queue<Node> queue = new LinkedList<Node>();
        queue.add(s);
        discovered.add(s);
        while (!queue.isEmpty()) {
            Node u = queue.remove();
            for (Node v : u.adjlist) {
                if (!discovered.contains(v)) {
                    discovered.add(v);
                    queue.add(v);
               }
           }
       }
       return discovered;
   }
    //} // BFS()


} // class Graph
